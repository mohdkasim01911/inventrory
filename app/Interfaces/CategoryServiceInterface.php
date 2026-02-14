<?php
namespace App\Interfaces;

use App\DTOs\CategoryDTO;

interface CategoryServiceInterface
{
    public function store(CategoryDTO $dto);
    public function update(CategoryDTO $dto, $category);
}
