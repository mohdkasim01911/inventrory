<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Supplier,Vendor};

use App\DTOs\SupplierDTO;
use App\Interfaces\SupplierServiceInterface;
use App\Http\Requests\SupplierRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Services\ExportService;
class SupplierController extends Controller
{
      protected $exportService;

    public function __construct(
        private SupplierServiceInterface $supplierService, ExportService $exportService
    ) {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $suppliers = Supplier::latest()->paginate(10);

        $perPage = $request->input('per_page', 10);

        $suppliers = Vendor::paginate($perPage)->appends(['per_page' => $perPage]);

        // For serial numbering with pagination
        $startingNumber = ($suppliers->currentPage() - 1) * $suppliers->perPage() + 1;
        return view('admin.suppliers.index', compact('suppliers','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {

        $dto = SupplierDTO::fromRequest($request);
        $this->supplierService->store($dto);

        
        return redirect()->route('suppliers.index')->with('success','Supplier added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $supplier)
    {
         return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierUpdateRequest $request, Vendor $supplier)
    {

        $dto = SupplierDTO::fromRequest($request);
        $this->supplierService->update($dto, $supplier);
        return redirect()->route('suppliers.index')->with('success','Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success','Supplier deleted successfully.');
    }
    public function export(Request $request, $type = null)
    {
        

        $table   = 'vendors';
        $columns = $request->columns ?? ['name','phone', 'gst_number','address','created_at'];
        $joins = [];

        return $this->exportService->export($table, $columns, $type, $joins);

       
    }
}
