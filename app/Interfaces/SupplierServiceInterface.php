<?php
namespace App\Interfaces;

use App\DTOs\SupplierDTO;

interface SupplierServiceInterface{
    public function store(SupplierDTO $dto);
    public function update(SupplierDTO $dto, $supplier);
}
