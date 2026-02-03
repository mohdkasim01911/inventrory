<?php
namespace App\Interfaces;

use App\DTOs\ProductDTO;

interface ProductServiceInterface{
    public function store(ProductDTO $dto);
    public function update(ProductDTO $dto, $product);
}
