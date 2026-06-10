<?php

namespace App\Services;

use App\Exceptions\AuthorAlreadyExistsException;
use App\Exceptions\AuthorHasBooksException;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorService
{

    public function listForAdmin(?string $searchTerm, int $perPage = 15)
    {
        $query = Author::query();

        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        return $query->orderBy('name', 'asc')->paginate($perPage);
    }

    public function listForCatalog(?string $searchTerm, ?string $selectedLetter, int $perPage = 16)
    {
        $query = Author::withCount('books')->orderBy('name', 'asc');

        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($selectedLetter) && strlen($selectedLetter) === 1) {
            $query->where('name', 'like', $selectedLetter . '%');
        }

        return $query->paginate($perPage);
    }

    public function getBooksPaginated(Author $author, int $perPage = 12): LengthAwarePaginator
    {
        return $author->books()
            ->with('category')
            ->orderBy('title', 'asc')
            ->paginate($perPage);
    }

    public function create(array $data): Author
    {
        $author = Author::withTrashed()->where('name', $data['name'])->first();

        if ($author) {
            if ($author->trashed()) {
                $author->restore();
                $author->books()->onlyTrashed()->restore();
                return $author;
            }
            throw new AuthorAlreadyExistsException("Este autor já está ativo na biblioteca.");
        }

        return Author::create($data);
    }

    public function update(int $id, array $data): Author
    {
        $author = Author::findOrFail($id);
        $author->update($data);
        return $author;
    }

    public function delete(int $id): bool
    {
        $author = Author::findOrFail($id);

        if ($author->books()->exists()) {
            throw new AuthorHasBooksException("Não é possível excluir este autor pois existem livros vinculados a ele.");
        }

        return $author->delete();
    }
}
