<?php
namespace App\DTOs;
class BillingDTO
{
    public function __construct(
        public int $customer_id ,
        public string $cash,
        public string $discount,
        public Array $products,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            customer_id: $request->customer_id,
            cash: $request->cash,
            products: $request->products,
            discount: $request->discount,
            
        );
    }
}