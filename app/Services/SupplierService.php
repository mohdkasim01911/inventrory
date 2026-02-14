<?php

namespace App\Services;



use App\Models\Vendor;

use App\DTOs\SupplierDTO;

use App\Interfaces\SupplierServiceInterface;



class SupplierService implements SupplierServiceInterface

{

    public function store(SupplierDTO $dto)

    {

        Vendor::create([

            'name' => $dto->name,

            'phone' => $dto->phone,

            'gst_number' => $dto->gst_number,

            'address' => $dto->address,

            'pan' => $dto->pan,

            'adhar' => $dto->adhar,

        ]);

    }



    public function update(SupplierDTO $dto, $supplier)

    {

         $supplier->update([

            'name' => $dto->name,

            'phone' => $dto->phone,

            'gst_number' => $dto->gst_number,

            'address' => $dto->address,

            'pan' => $dto->pan,

            'adhar' => $dto->adhar,

         ]);

    }

}







