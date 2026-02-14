<?php
namespace App\Services;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use Illuminate\Support\Str;
use App\Interfaces\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    public function store(CategoryDTO $dto)
    {
        return Category::create([
            'name' => $dto->name,
            'slug' => str::slug($dto->name),
        ]);
    }

    public function update(CategoryDTO $dto, $category)
    {
        $slug = Str::slug($dto->name);

        // Unique slug check (optional but recommended)
        $originalSlug = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $category->update([
            'name' => $dto->name,
            'slug' => $slug,
        ]);
    }
}



