<?php

namespace App\Services;

use App\Exceptions\BookAlreadyExistsException;
use App\Exceptions\BookHasActiveLoansException;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    public function __construct(
        protected OpenLibraryService $openLibraryService
    ) {}

    public function listByCategory(Category $category, ?string $searchTerm, int $perPage = 12): LengthAwarePaginator
    {
        $query = $category->books()->with('author');

        if (!empty($searchTerm)) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        return $query->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($perPage);
    }

    public function listForAdmin(?string $searchTerm, int $perPage = 15): LengthAwarePaginator
    {
        $query = Book::with(['author', 'category']);

        if (!empty($searchTerm)) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        return $query->orderBy('title', 'asc')->paginate($perPage);
    }

    public function create(array $data): Book
    {
        if (!empty($data['isbn'])) {
            $exists = Book::where('isbn', $data['isbn'])->exists();
            if ($exists) {
                throw new BookAlreadyExistsException("Já existe um livro cadastrado com este ISBN.");
            }
        } else {
            $data['isbn'] = 'INT-' . uniqid();
        }

        return Book::create($data);
    }

    public function updateFull(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }

    public function updateStock(Book $book, int $stock): Book
    {
        $book->update([
            'stock' => $stock
        ]);

        return $book;
    }

    public function delete(int $id): bool
    {
        $book = Book::findOrFail($id);

        $hasActiveLoans = $book->loans()
            ->whereIn('status', ['PENDING', 'ACTIVE', 'OVERDUE'])
            ->exists();

        if ($hasActiveLoans) {
            throw new BookHasActiveLoansException("Não é possível excluir o livro '{$book->title}' pois ele possui empréstimos ativos ou pendentes.");
        }

        return $book->delete();
    }

    public function importBooksFromApi(int $categoryId, int $limit): int
    {
        $category = Category::findOrFail($categoryId);

        $works = $this->openLibraryService->fetchBooksBySubject($category->name, $limit);

        $booksImported = 0;

        foreach ($works as $work) {

            $authorName = $work['authors'][0]['name'] ?? 'Autor Desconhecido';

            $author = Author::firstOrCreate(
                ['name' => $authorName]
            );

            $uniqueKey = $work['key']; // /works/OL1234W tipo o isbn

            $book = Book::firstOrCreate(
                ['isbn' => $uniqueKey],
                [
                    'title'       => $work['title'],
                    'stock'       => rand(0, 30),
                    'author_id'   => $author->id,
                    'category_id' => $category->id,
                    'cover_id'    => $work['cover_id'] ?? null
                ]
            );

            if ($book->wasRecentlyCreated) {
                $booksImported++;
            }
        }

        return $booksImported;
    }
}
