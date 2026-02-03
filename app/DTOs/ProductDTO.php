<?php 
namespace App\DTOs;
class ProductDTO
{
   
     public function __construct(
         public int $category_id,
         public string $name,
         public string $serial_number,
         public string $price,
         public int $stock,

      ){}

      public static function fromRequest($request): self
      {
         return new self(
            category_id: $request->category_id,
            name: $request->name,
            serial_number: $request->serial_number,
            price: $request->price,
            stock: $request->stock,
         );
      }



}