<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category,Product};
use App\Http\Requests\ProductStoreRequest;
use App\DTOs\ProductDTO;
use App\Interfaces\ProductServiceInterface;
use App\Services\ExportService;

class ProductController extends Controller
{
    protected $exportService;
   
    public function __construct(
        private ProductServiceInterface $productService, ExportService $exportService
    ){
        $this->exportService = $exportService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        $products = Product::with('category')->paginate($perPage)->appends(['per_page' => $perPage]);

        // For serial numbering with pagination
        $startingNumber = ($products->currentPage() - 1) * $products->perPage() + 1;
        return view('admin.products.index', compact('products','startingNumber', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {   
        $dto = ProductDTO::fromRequest($request);
        $this->productService->store($dto);
        return redirect()->route('products.index')->with('success','Product added successfully.');
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
    public function edit(Product $product)
    {
         $categories = Category::all();
        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, Product $product)
    {

        $dto = ProductDTO::fromRequest($request);
        $this->productService->update($dto, $product);
        return redirect()->route('products.index')->with('success','Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Product deleted successfully.');
    }

    public function export(Request $request, $type = null)
    {
        $table = 'products';

        $columns = [
            'products.name as name',
            'products.price as price',
            'products.stock as stock',
            'products.serial_number as serial_number',
            'categories.name as category_name'
        ];

        $joins = [
            [
                'table'  => 'categories',
                'first'  => 'products.category_id',
                'second' => 'categories.id'
            ]
        ];

        return $this->exportService->export($table, $columns, $type, $joins);
    }

}
