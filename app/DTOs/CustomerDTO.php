<?php

namespace App\DTOs;

class CustomerDTO

{

    public function __construct(

        public string $name,

        public int $contact,

        public ?string $email = null,
        
        public ?string $pan = null,

        public ?string $adhar = null,

    ) {}



    public static function fromRequest($request): self

    {

        return new self(

            name: $request->name,

            contact: $request->contact,

            email: $request->email,

            pan: $request->pan,

            adhar: $request->adhar,

        );

    }

}