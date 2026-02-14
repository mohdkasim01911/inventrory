<?php

namespace App\DTOs;

class SupplierDTO

{

    public function __construct(

        public string $name,

        public int $phone,

        public string $gst_number,

        public ?string $address = null,
        
        public ?string $pan = null,

        public ?string $adhar = null,

    ) {}



    public static function fromRequest($request): self

    {

        return new self(

            name: $request->name,

            phone: $request->phone,

            gst_number: $request->gst_number,

            address: $request->address,

            pan: $request->pan,

            adhar: $request->adhar,

        );

    }

}