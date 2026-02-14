<?php 
namespace App\DTOs;
use Carbon\Carbon;
class ProductDTO
{
   
     public function __construct(
         public int $category_id,
         public string $name,
         public ?int $ampere = null,
         public ?Carbon $date = null,
         public ?int $month = null,
         // public int $stock,

      ){}

      public static function fromRequest($request): self
      {
         return new self(
            category_id: $request->category_id,
            name: $request->name,
            ampere: $request->ampere,
            date: $request->date ? Carbon::parse($request->date) : null,
            month: $request->month,
            // stock: $request->stock,
         );
      }



}