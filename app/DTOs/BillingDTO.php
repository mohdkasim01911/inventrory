<?php
namespace App\DTOs;
use Carbon\Carbon;
class BillingDTO
{
    public function __construct(
        public int $customer_id,
        public string $cash,
        public string $discount,
        public Array $products,
        public ?string $details = null,
        public ?Carbon $date = null,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            customer_id: $request->customer_id,
            cash: $request->cash,
            products: $request->products,
            discount: $request->discount,
            details: $request->details,
            date: $request->date ? Carbon::parse($request->date) : null,
        );
    }
}