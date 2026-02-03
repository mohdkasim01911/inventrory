<?php
namespace App\Services;

use App\Models\Product;
use App\DTOs\ProductDTO;
use App\Interfaces\ProductServiceInterface;
class ProductService implements ProductServiceInterface{

    public function store(ProductDTO $dto)
    {
         Product::create([
            'category_id' => $dto->category_id,
            'name' => $dto->name,
            'serial_number' => $dto->serial_number,
            'price' => $dto->price,
            'stock' => $dto->stock,
        ]);
    }

    public function update(ProductDTO $dto, $product)
    {
         $product->update([
            'category_id' => $dto->category_id,
            'name' => $dto->name,
            'serial_number' => $dto->serial_number,
            'price' => $dto->price,
            'stock' => $dto->stock,
        ]);
    }


}