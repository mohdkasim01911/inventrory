<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Customer,Payable,PayableLog};
use Carbon\Carbon;
use Auth;
use App\Http\Requests\PayableRequest;
use App\Services\ExportService;
class PayableController extends Controller
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
        $payble = Payable::paginate($perPage)->appends(['per_page' => $perPage]);
        $startingNumber = ($payble->currentPage() - 1) * $payble->perPage() + 1;
        return view('admin.payble.index', compact('payble','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $customer = Customer::all();
         return view('admin.payble.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PayableRequest $request)
    {
        Payable::create([
            'customer_id' => $request->customer_id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'pending',
            'remarks' => $request->remarks,
        ]);

    return redirect()->route('paybles.index')->with('success', 'Payable added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $today = Carbon::today();
        $perPage = $request->input('per_page', 10);
        $payble = Payable::whereDate('due_date', '<=', $today)
        ->with('customer')->paginate($perPage)->appends(['per_page' => $perPage]);
        $startingNumber = ($payble->currentPage() - 1) * $payble->perPage() + 1;
        return view('admin.payble.index', compact('payble','startingNumber', 'perPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payable $payble)
    {
         $customer = Customer::all();
        return view('admin.payble.edit', compact('payble','customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PayableRequest $request, Payable $payble)
    {
        $due_amount = $payble->amount - $request->amount;
        $status = 'pending';
        if($due_amount <= 0){
            $status = 'paid';
        }
        $payble->update([
            'customer_id' => $request->customer_id,
            'pay_amount' => $request->amount,
            'due_amount' => $due_amount,
            'due_date' => $request->due_date,
            'status' => $status,
            'remarks' => $request->remarks,
        ]);

       PayableLog::create([
          'payable_id' => $payble->id,
          'pay_amount' => $request->amount,
          'due_amount' => $due_amount,
       ]);


        return redirect()->route('paybles.index')->with('success', 'Payable updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payable $payble)
    {
        $payble->delete();
        return redirect()->route('paybles.index')->with('success', 'Payable deleted successfully');
    }

    public function log($id){
        $data = PayableLog::where('payable_id',$id)->paginate(10);
         return view('admin.payble.show', compact('data'));
    }

    public function export(Request $request, $type = null)
    {
        $table = 'payables';

        $columns = [
            'payables.amount as amount',
            'payables.due_date as due_date',
            'payables.status as status',
            'payables.remarks as remarks',
            'payables.pay_amount as pay_amount',
            'payables.due_amount as due_amount',
            'customers.name as name'
        ];

        $joins = [
            [
                'table'  => 'customers',
                'first'  => 'payables.customer_id',
                'second' => 'customers.id'
            ]
        ];

        return $this->exportService->export($table, $columns, $type, $joins);
    }
}
