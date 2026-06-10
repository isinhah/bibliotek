<?php

namespace App\Services;

use App\Exceptions\CategoryAlreadyExistsException;
use App\Exceptions\CategoryHasBooksException;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryService
{
    public function listForAdmin(?string $searchTerm, int $perPage = 15): LengthAwarePaginator
    {
        $query = Category::query();

        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        return $query->orderBy('name', 'asc')->paginate($perPage);
    }

    public function listForCatalog(): Collection
    {
        return Category::withCount('books')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function listAll(): Collection
    {
        return Category::all();
    }

    public function create(array $data): Category
    {
        $category = Category::withTrashed()->where('name', $data['name'])->first();

        if ($category) {
            if ($category->trashed()) {
                $category->restore();
                return $category;
            }

            throw new CategoryAlreadyExistsException("Esta categoria já está ativa na biblioteca.");
        }

        return Category::create($data);
    }

    public function update(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function delete(int $id): bool
    {
        $category = Category::findOrFail($id);

        if ($category->books()->exists()) {
            throw new CategoryHasBooksException("Não é possível excluir esta categoria pois existem livros vinculados a ela.");
        }

        return $category->delete();
    }
}
