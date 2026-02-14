<?php
namespace App\Services;

use App\Models\{Billing,Product,BillingItem,BillItemSerial};
use App\DTOs\BillingDTO;
use App\Interfaces\BillingServiceInterface;
use DB;

class BillingService implements BillingServiceInterface
{
    public function store(BillingDTO $dto)
    {

            $subtotal = 0;
            $gstTotal = 0;

            foreach ($dto->products as $item) {

                $product = Product::findOrFail($item['product_id']);
                $qty = (int) $item['quantity'];
                $gstPercent = (float) $item['gst'];

                if ($product->stock < $qty) {
                    return back()->with('error', 'Stock not available');
                }

                $lineTotal = $item['amount'] * $qty;
                $gstAmount = ($lineTotal * $gstPercent) / 100;

                $subtotal += $lineTotal;
                $gstTotal += $gstAmount;

                $product->stock -= $qty;
                $product->save();
            }

            $invoice = Billing::create([
                'customer_id' => $dto->customer_id,
                'subtotal' => $subtotal,
                'gst_amount' => $gstTotal,
                'total_amount' => $subtotal + $gstTotal,
                'discount' => $dto->discount,
                'cash' => $dto->cash,
                'details' => $dto->details,
                'date' => $dto->date,
            ]);

            foreach ($dto->products as $item) {
                $product = Product::find($item['product_id']);
                $qty = $item['quantity'];
                $gstPercent = $item['gst'];

                $lineTotal = $item['amount'] * $qty;
                $gstAmount = ($lineTotal * $gstPercent) / 100;

               $itm = BillingItem::create([
                    'billing_id' => $invoice->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $item['amount'],
                    'gst_percent' => $gstPercent,
                    'gst_amount' => $gstAmount,
                    'total' => $lineTotal + $gstAmount,
                ]);

                if (!empty($item['serials'])) {
                foreach ($item['serials'] as $serial) {
                    BillItemSerial::create([
                        'billing_item_id' => $itm->id,
                        'serial_number' => $serial,
                    ]);
                }
            }
            }

            DB::commit();

           return $invoice;
    }

    public function update(BillingDTO $dto, $billing){

          $billing = $billing->load('items.serials');


           /*
            |--------------------------------------------------------------------------
            | 1️⃣ RESTORE OLD STOCK
            |--------------------------------------------------------------------------
            */

          foreach ($billing->items as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->stock += $oldItem->quantity;
                    $product->save();
                }
          }


            /*
            |--------------------------------------------------------------------------
            | 2️⃣ DELETE OLD ITEMS & SERIALS
            |--------------------------------------------------------------------------
            */
            foreach ($billing->items as $item) {
                $item->serials()->delete();
            }
            $billing->items()->delete();



        /*
        |--------------------------------------------------------------------------
        | 3️⃣ CALCULATE NEW TOTALS + CHECK STOCK
        |--------------------------------------------------------------------------
        */
        $subtotal = 0;
        $gstTotal = 0;

        foreach ($dto->products as $item) {

            $product = Product::findOrFail($item['product_id']);
            $qty = (int) $item['quantity'];
            $gstPercent = (float) $item['gst'];

            if ($product->stock < $qty) {
                DB::rollBack();
                return back()->with('error', 'Stock not available');
            }

            $lineTotal = $item['amount'] * $qty;
            $gstAmount = ($lineTotal * $gstPercent) / 100;

            $subtotal += $lineTotal;
            $gstTotal += $gstAmount;

            // 🔻 deduct new stock
            $product->stock -= $qty;
            $product->save();
        }

        /*
        |--------------------------------------------------------------------------
        | 4️⃣ UPDATE BILLING MASTER
        |--------------------------------------------------------------------------
        */
        $billing->update([
            'customer_id'  => $dto->customer_id,
            'subtotal'     => $subtotal,
            'gst_amount'   => $gstTotal,
            'total_amount' => $subtotal + $gstTotal,
            'discount'     => $dto->discount,
            'cash'         => $dto->cash,
            'details'      => $dto->details,
            'date'         => $dto->date,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5️⃣ INSERT NEW ITEMS & SERIALS
        |--------------------------------------------------------------------------
        */
        foreach ($dto->products as $item) {

            $qty = $item['quantity'];
            $gstPercent = $item['gst'];

            $lineTotal = $item['amount'] * $qty;
            $gstAmount = ($lineTotal * $gstPercent) / 100;

            $billingItem = BillingItem::create([
                'billing_id'  => $billing->id,
                'product_id'  => $item['product_id'],
                'quantity'    => $qty,
                'price'       => $item['amount'],
                'gst_percent' => $gstPercent,
                'gst_amount'  => $gstAmount,
                'total'       => $lineTotal + $gstAmount,
            ]);

            if (!empty($item['serials'])) {
                foreach ($item['serials'] as $serial) {
                    if ($serial) {
                        BillItemSerial::create([
                            'billing_item_id' => $billingItem->id,
                            'serial_number'   => $serial,
                        ]);
                    }
                }
            }
        }

        DB::commit();

        return $billing;

    }

  
}



