<?php

namespace App\Services;

use App\Exceptions\OpenLibraryException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenLibraryService
{
    protected const BASE_URL = 'https://openlibrary.org';

    public function fetchBooksBySubject(string $subject, int $limit = 50): array
    {
        $formattedTerm = Str::snake(Str::lower(trim($subject)));

        $response = Http::timeout(30)
            ->retry(3, 100)
            ->get(self::BASE_URL . "/subjects/{$formattedTerm}.json", [
                'limit' => $limit
            ]);

        if ($response->failed()) {
            throw new OpenLibraryException("Não foi possível conectar à API da Open Library (Status: " . $response->status() . ").");
        }

        return $response->json()['works'] ?? [];
    }
}
