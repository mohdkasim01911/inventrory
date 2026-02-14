<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Billing,Customer,Product,BillingItem};
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\DTOs\BillingDTO;
use App\Interfaces\BillingServiceInterface;
use App\Http\Requests\BillingStoreRequest;
use App\Services\ExportService;

class BillingController extends Controller
{

    protected $exportService;
    public function __construct(
        private BillingServiceInterface $billingService, ExportService $exportService
    ) {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //  $invoices = Invoice::with('customer')->latest()->get();

       $perPage = $request->input('per_page', 10);

       $invoices = Billing::paginate($perPage)->appends(['per_page' => $perPage]);

        // For serial numbering with pagination
        $startingNumber = ($invoices->currentPage() - 1) * $invoices->perPage() + 1;

        return view('admin.billing.index',compact('invoices','perPage','startingNumber'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $customers = Customer::select('id','name')->get();
        $products = Product::all();
        return view('admin.billing.create', compact('customers','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillingStoreRequest $request)
    {
         
          DB::beginTransaction();
        try {
            $dto = BillingDTO::fromRequest($request);
            $invoice =  $this->billingService->store($dto);
            return redirect()->route('billings.show', $invoice->id);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Billing $billing)
    {
        $billing->load('customer','items.product','items.serials');
        return view('admin.billing.show', compact('billing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billing $billing)
    {

         $billing = $billing->load('items.product','items.serials');
         $customers = Customer::select('id','name')->get();
         $products = Product::all();
         return view('admin.billing.edit', compact('billing','customers','products'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Billing $billing)
    {

         DB::beginTransaction();
        try {
            $dto = BillingDTO::fromRequest($request);
            $invoice =  $this->billingService->update($dto, $billing);
            return redirect()->route('billings.show', $invoice->id);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download($id) {
        $billing = Billing::find($id);
        $billing->load('customer','items.product');
        $pdf = Pdf::loadView('admin.billing.pdf', compact('billing'));
        return $pdf->download('invoice-'.$billing->id.'.pdf');
    }

    public function export(Request $request, $type = null)
    {
        $table = 'billings';

        $columns = [
            'billings.total_amount as total_amount',
            'billings.tax as tax',
            'billings.discount as discount',
            'billings.cash as cash',
            'billings.gst_amount as gst_amount',
            'billings.subtotal as subtotal',
            'customers.name as customer_name'
        ];

        $joins = [
            [
                'table'  => 'customers',
                'first'  => 'billings.customer_id',
                'second' => 'customers.id'
            ]
        ];

        return $this->exportService->export($table, $columns, $type, $joins);
    }
}
