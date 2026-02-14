<?php
namespace App\Interfaces;

use App\DTOs\BillingDTO;

interface BillingServiceInterface
{
    public function store(BillingDTO $dto);
    public function update(BillingDTO $dto, $billing);
}