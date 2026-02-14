<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employee,EmployeeMonthAmount};
use App\Services\ExportService;
use Carbon\Carbon;
class EmployeeController extends Controller
{

    public function __construct(
     ExportService $exportService
    ) {
        $this->exportService = $exportService;
     }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        // $employees = Employee::paginate($perPage)->appends(['per_page' => $perPage]);

        $employees = Employee::withSum(['monthAmounts as current_month_amount' => function ($q) {
            $q->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
        }],'amount')->paginate($perPage)->appends(['per_page' => $perPage]);

        // For serial numbering with pagination
        $startingNumber = ($employees->currentPage() - 1) * $employees->perPage() + 1;

        return view('admin.employee.index',compact('employees','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|unique:employees,email',
            'phone' => 'required|numeric',
            'salary' => 'required',
        ]);
        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success','Employe created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $startOfMonth = Carbon::now()->startOfMonth();
       $endOfMonth = Carbon::now()->endOfMonth();

       $data = EmployeeMonthAmount::whereBetween('created_at', [$startOfMonth, $endOfMonth]);
       $totalAmount = $data->where('employee_id',$id)->sum('amount');
       $data = $data->where('employee_id',$id)->latest()->paginate(10);

        return view('admin.employee.show',compact('data','id','totalAmount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('admin.employee.edit',compact('employee'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|numeric',
            'salary' => 'required',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success','Employe updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success','Employe deleted');
    }

    public function export(Request $request, $type = null)
    {
        $table   = 'employees';
        $columns = $request->columns ?? ['name','email', 'phone','salary','address'];
        $joins = [];

        return $this->exportService->export($table, $columns, $type, $joins);
    }

    public function showStore(Request $request){

         $request->validate([
            'details' => 'required',
            'amount' => 'required|numeric',
        ]);
        
        EmployeeMonthAmount::create($request->all());
        return redirect()->route('employees.show',$request->employee_id)->with('success','Employee expensses added');
    }

    public function showDelete(Request $request, $id){
        EmployeeMonthAmount::find($id)->delete();
        return redirect()->route('employees.show',$request->employee_id)->with('success','Employee expensses added');
    }
}
