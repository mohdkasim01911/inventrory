<?php
namespace App\Interfaces;

use App\DTOs\CustomerDTO;

interface CustomerServiceInterface{
    public function store(CustomerDTO $dto);
    public function update(CustomerDTO $dto, $supplier);
}
