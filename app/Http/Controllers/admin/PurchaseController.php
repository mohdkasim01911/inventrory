<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Purchase,Product,Vendor,PurchaseItem,PurchaseSerial};
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\PurchaseStoreRequest;
use App\Services\ExportService;
class PurchaseController extends Controller
{

    protected $exportService;

     public function __construct(ExportService $exportService) {
        $this->exportService = $exportService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

         $perPage = $request->input('per_page', 10);

         $purchases = Purchase::paginate($perPage)->appends(['per_page' => $perPage]);

        // For serial numbering with pagination
         $startingNumber = ($purchases->currentPage() - 1) * $purchases->perPage() + 1;


        return view('admin.purchases.index',compact('purchases','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.purchases.create',[
            'vendors'=>Vendor::all(),
            'products'=>Product::all()
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseStoreRequest $request)
    {

    
        DB::transaction(function() use ($request){

        $purchase = Purchase::create([
            'vendor_id'=>$request->vendor_id,
            'invoice_no'=>$request->invoice_no,
            'invoice_date'=>$request->invoice_date,
            'subtotal'=>$request->subtotal,
            'gst_amount'=>$request->gst_amount,
            'total_amount'=>$request->grand_total,
        ]);

        foreach($request->product_id as $i=>$pid){

        PurchaseItem::create([
                'purchase_id'=>$purchase->id,
                'product_id'=>$pid,
                'quantity'=>$request->qty[$i],
                'price'=>$request->price[$i],
                'gst_percent'=>$request->gst[$i],
                'gst_amount'=>$request->gst_amt[$i],
                'total'=>$request->total[$i],
            ]);

            if (!empty($request->serial_numbers[$i])) {

                foreach ($request->serial_numbers[$i] as $serial) {

                    PurchaseSerial::create([
                        'purchase_id' => $purchase->id,
                        'product_id'  => $pid,
                        'serial_number'   => $serial,
                        'status'      => 1, // Available
                    ]);
                }
            }
            // 🔥 STOCK INCREASE
            Product::where('id',$pid)
                ->increment('stock',$request->qty[$i]);
            }
        });

        return redirect('/purchases')->with('success','Purchase Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      return view('admin.purchases.show',[
        'purchase'=>Purchase::with('items.product','vendor')->findOrFail($id)
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchase = Purchase::with([
            'items',
            'serials'   // relation honi chahiye
        ])->findOrFail($id);

        $vendors  = Vendor::all();
        $products = Product::all();

        return view('admin.purchases.edit',compact('purchase','vendors','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
           DB::transaction(function () use ($request, $id) {

                $purchase = Purchase::with(['items', 'serials'])->findOrFail($id);

                /**
                 * 🔥 STEP 1: OLD STOCK REVERSE
                 */
                foreach ($purchase->items as $item) {
                    Product::where('id', $item->product_id)
                        ->decrement('stock', $item->quantity);
                }

                /**
                 * 🔥 STEP 2: DELETE OLD ITEMS & SERIALS
                 */
                $purchase->items()->delete();
                $purchase->serials()->delete();

                /**
                 * 🔥 STEP 3: UPDATE PURCHASE MASTER
                 */
                $purchase->update([
                    'vendor_id'    => $request->vendor_id,
                    'invoice_no'   => $request->invoice_no,
                    'invoice_date' => $request->invoice_date,
                    'subtotal'     => $request->subtotal,
                    'gst_amount'   => $request->gst_amount,
                    'total_amount' => $request->grand_total,
                ]);

                /**
                 * 🔥 STEP 4: INSERT NEW ITEMS + SERIALS + STOCK
                 */
                foreach ($request->product_id as $i => $pid) {

                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id'  => $pid,
                        'quantity'    => $request->qty[$i],
                        'price'       => $request->price[$i],
                        'gst_percent' => $request->gst[$i],
                        'gst_amount'  => $request->gst_amt[$i],
                        'total'       => $request->total[$i],
                    ]);

                    // SERIAL NUMBERS
                    if (!empty($request->serial_numbers[$i])) {
                        foreach ($request->serial_numbers[$i] as $serial) {

                            PurchaseSerial::create([
                                'purchase_id'   => $purchase->id,
                                'product_id'    => $pid,
                                'serial_number' => $serial,
                                'status'        => 1, // Available
                            ]);
                        }
                    }

                    // 🔥 STOCK INCREASE
                    Product::where('id', $pid)
                        ->increment('stock', $request->qty[$i]);
                }
            });

          return redirect()->route('purchases.show',$id)->with('success','Purchase Updated');
  

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download($id) {
        $purchase = Purchase::with('items.product','vendor')->findOrFail($id);
        $pdf = Pdf::loadView('admin.purchases.pdf', compact('purchase'));
        return $pdf->download('invoice-'.$purchase->id.'.pdf');
    }

    public function export(Request $request, $type = null)
    {
        $table = 'purchases';

        $columns = [
            'purchases.invoice_no as invoice_no',
            'purchases.invoice_date as invoice_date',
            'purchases.subtotal as subtotal',
            'purchases.gst_amount as gst_amount',
            'purchases.total_amount as total_amount',
            'vendors.name as supplier_name'
        ];

        $joins = [
            [
                'table'  => 'vendors',
                'first'  => 'purchases.vendor_id',
                'second' => 'vendors.id'
            ]
        ];

        return $this->exportService->export($table, $columns, $type, $joins);
    }
}
