<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Customer, Purchase,Billing, Vendor, Product, Emi, Payable, Category, Expenses};
use App\DTOs\CustomerDTO;
use App\Interfaces\CustomerServiceInterface;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerupdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\ExportService;
class CustomerController extends Controller
{

     public function __construct(
        private CustomerServiceInterface $customerService, ExportService $exportService
    ) {
        $this->exportService = $exportService;
     }
    /**
     * Display a listing of the resource.
     */

       public function dashboard(Request $request){

           $years = $request->filled('year') ? $request->year : now()->year;

            $totalPurchase = Purchase::whereYear('created_at', $years)
                ->sum('total_amount') ?? 0;

            $totalSale = Billing::whereYear('created_at', $years)
            ->sum('total_amount') ?? 0;

            $customer = Customer::whereYear('created_at', $years)->count() ?? 0;
            $supplier = Vendor::whereYear('created_at', $years)->count() ?? 0;
            $product  = Product::whereYear('created_at', $years)->count() ?? 0;
            $emi      = Emi::whereYear('created_at', $years)->count()?? 0;
            $payable  = Payable::whereYear('created_at', $years)->count()?? 0;
            $Category = Category::whereYear('created_at', $years)->count()?? 0;
            $expenses = Expenses::whereYear('created_at', $years)->sum('amount')?? 0;

            $monthlyData = Billing::selectRaw('
                    MONTH(created_at) as month,
                    SUM(total_amount) as total
                ')
                ->whereYear('created_at',$years)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

                $monthlyPurchaseData = Purchase::selectRaw('
                    MONTH(created_at) as month,
                    SUM(total_amount) as total
                ')
                ->whereYear('created_at',$years)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

                $monthlySales = [];

                for ($i = 1; $i <= 12; $i++) {
                    $monthlySales[] = $monthlyData[$i] ?? 0;
                }

                $monthlyPurchase = [];

                for ($i = 1; $i <= 12; $i++) {
                    $monthlyPurchase[] = $monthlyPurchaseData[$i] ?? 0;
                }

           return view('dashboard', compact('monthlyPurchase','monthlySales','totalSale','totalPurchase','customer','supplier','product','emi','payable','Category', 'expenses','years'));
    }

    public function index(Request $request)
    {  
        $perPage = $request->input('per_page', 10);
        $customers = Customer::paginate($perPage)->appends(['per_page' => $perPage]);
        // For serial numbering with pagination
        $startingNumber = ($customers->currentPage() - 1) * $customers->perPage() + 1;
        return view('admin.customers.index', compact('customers','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
         $dto = CustomerDTO::fromRequest($request);
         $this->customerService->store($dto);
        return redirect()->route('customers.index')->with('success','Customer added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerupdateRequest $request, Customer $customer)
    {
        $dto = CustomerDTO::fromRequest($request);
        $this->customerService->update($dto,$customer);
        return redirect()->route('customers.index')->with('success','Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
       $customer->delete();
        return redirect()->route('customers.index')->with('success','Customer deleted successfully.');
    }

    public function export(Request $request, $type = null)
    {
        

        $table   = 'customers';
        $columns = $request->columns ?? ['name','contact', 'email','created_at'];
        $joins = [];

        return $this->exportService->export($table, $columns, $type, $joins);

       
    }
}
