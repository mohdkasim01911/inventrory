<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Services\ExportService;
class ExpensesController extends Controller
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
        $expenses = Expenses::latest()->paginate($perPage)->appends(['per_page' => $perPage]);

         // For serial numbering with pagination
        $startingNumber = ($expenses->currentPage() - 1) * $expenses->perPage() + 1;
        return view('admin.expenses.index', compact('expenses','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required'
        ]);

        Expenses::create($request->all());
       
        return redirect()->route('expenses.index')->with('success','Expenses added successfully.');
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
    public function edit(int $id)
    {
         $expenses = Expenses::find($id); 
        return view('admin.expenses.edit',compact('expenses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required'
        ]);

        $expenses = Expenses::find($id);
        $expenses->update($request->all());
        return redirect()->route('expenses.index')->with('success','Expenses updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Expenses::find($id)->delete();
        return redirect()->route('expenses.index')->with('success','Expenses deleted successfully.');
    }

    public function export(Request $request, $type = null)
    {
        $table = 'expenses';

        $columns = [
            'title',
            'name',
            'amount',
            'description',
            'created_at',
        ];

        $joins = [];

        return $this->exportService->export($table, $columns, $type, $joins);
    }
}
