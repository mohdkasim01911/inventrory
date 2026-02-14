<?php

namespace App\Services;



use App\Models\Customer;

use App\DTOs\CustomerDTO;

use App\Interfaces\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface{



    public function store(CustomerDTO $dto)

    {

         Customer::create([

            'name' => $dto->name,

            'contact' => $dto->contact,

            'email' => $dto->email,

            'pan' => $dto->pan,

            'adhar' => $dto->adhar,

        ]);

    }



    public function update(CustomerDTO $dto, $product)

    {

         $product->update([

            'name' => $dto->name,

            'contact' => $dto->contact,

            'email' => $dto->email,

            'pan' => $dto->pan,

            'adhar' => $dto->adhar,

        ]);

    }





}