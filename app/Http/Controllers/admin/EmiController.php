<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Emi,Billing,EmiLog};
use Carbon\Carbon;
use App\Services\ExportService;

class EmiController extends Controller
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
        $emis = Emi::paginate($perPage)->appends(['per_page' => $perPage]);
        $startingNumber = ($emis->currentPage() - 1) * $emis->perPage() + 1;
        return view('admin.emi.index', compact('emis','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($saleId)
    {
        $sale = Billing::findOrFail($saleId);
        return view('admin.emi.create', compact('sale'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'installments' => 'required',
         ]);

        $sale = Billing::findOrFail($request->billing_id);

        $totalAmount = $sale->total_amount - $sale->discount - $sale->cash;

        $installments = $request->installments;
        $installmentAmount = $totalAmount / $installments;

        $emi = Emi::create([
            'billing_id' => $sale->id,
            'customer_id' => $sale->customer_id,
            'total_amount' => $totalAmount,
            'installments' => $installments,
            'installment_amount' => $installmentAmount,
            'due_amount' => $totalAmount,
            'next_due_date' => Carbon::now()->addMonth(),
            'status' => 'pending',
        ]);

        return redirect()->route('emis.index')->with('success', 'EMI created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $data = EmiLog::where('emi_id',$id)->paginate(10);
         return view('admin.emi.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Emi $emi)
    {
        return view('admin.emi.edit', compact('emi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Emi $emi)
    {


        $request->validate([
            'amount' => 'required',
            'paid_date' => 'required',
         ]);

        $emi->paid_amount += $request->amount;
        $emi->due_amount -= $request->amount;
        $emi->paid_date = $request->paid_date;

        if ($emi->due_amount <= 0) {
            $emi->status = 'completed';
            $emi->due_amount = 0;
        } else {
            $emi->status = 'partially_paid';
            $emi->next_due_date = Carbon::now()->addMonth();
        }

        $emi->save();

        EmiLog::create([
            'emi_id' => $emi->id,
            'installment_amount' => $emi->installment_amount,
            'paid_amount' => $request->amount,
            'paid_date' => $request->paid_date,
            'due_amount' => $emi->due_amount,
        ]);

        return redirect()->route('emis.index')->with('success', 'EMI paid successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request, $type = null)
    {
        $table = 'emis';

        $columns = [
            'emis.total_amount as total_amount',
            'emis.installments as installments',
            'emis.installment_amount as installment_amount',
            'emis.paid_amount as paid_amount',
            'emis.due_amount as due_amount',
            'emis.next_due_date as next_due_date',
            'emis.status as status',
            'customers.name as customer_name'

        ];

        $joins = [
            [
                'table'  => 'customers',
                'first'  => 'emis.customer_id',
                'second' => 'customers.id'
            ]
        ];

        return $this->exportService->export($table, $columns, $type, $joins);
    }
}
