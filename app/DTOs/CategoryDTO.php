<?php
namespace App\DTOs;
class CategoryDTO
{
    public function __construct(
        public string $name,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            name: $request->name,
        );
    }
}
