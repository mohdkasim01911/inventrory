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

  
}



