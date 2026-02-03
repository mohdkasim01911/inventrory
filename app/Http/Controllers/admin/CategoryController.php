<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\DTOs\CategoryDTO;
use App\Interfaces\CategoryServiceInterface;
use App\Http\Requests\CategoryStoreRequest;
use App\Services\ExportService;


class CategoryController extends Controller
{

    protected $exportService;
  
    public function __construct(
        private CategoryServiceInterface $categoryService, ExportService $exportService
    ) {
        $this->exportService = $exportService;
    }



    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $categories = Category::latest()->paginate($perPage)->appends(['per_page' => $perPage]);

         // For serial numbering with pagination
        $startingNumber = ($categories->currentPage() - 1) * $categories->perPage() + 1;
        return view('admin.category.index', compact('categories','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {

        $dto = CategoryDTO::fromRequest($request);
        $this->categoryService->store($dto);
        return redirect()->route('categories.index')->with('success','Category added successfully.');
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
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryStoreRequest $request, Category $category)
    {
        $dto = CategoryDTO::fromRequest($request);
        $this->categoryService->update($dto, $category);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success','Category deleted successfully.');
    }

    public function export(Request $request, $type = null)
    {
        

        $table   = 'categories';
        $columns = $request->columns ?? ['name','slug', 'created_at'];
        $joins = [];

        return $this->exportService->export($table, $columns, $type, $joins);

       
    }
}
