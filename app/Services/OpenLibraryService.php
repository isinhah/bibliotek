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

        $response = Http::timeout(20)
            ->retry(4, 100)
            ->get(self::BASE_URL . "/subjects/{$formattedTerm}.json", [
                'limit' => $limit
            ]);

        if ($response->failed()) {
            throw new OpenLibraryException("Não foi possível conectar à API da Open Library (Status: " . $response->status() . ").");
        }

        return $response->json()['works'] ?? [];
    }

    public function fetchWorkDetails(string $workKey): array
    {
        try {
            $response = Http::timeout(5)
                ->get(self::BASE_URL . "{$workKey}/editions.json", [
                    'limit' => 5
                ]);

            if ($response->successful()) {
                $entries = $response->json()['entries'] ?? [];

                $selectedEdition = collect($entries)->first(function ($edition) {
                    return !empty($edition['number_of_pages']) && !empty($edition['publishers']);
                }) ?? ($entries[0] ?? null);

                if ($selectedEdition) {
                    return [
                        'number_of_pages' => $selectedEdition['number_of_pages'] ?? null,
                        'publisher'       => $selectedEdition['publishers'][0] ?? null,
                        'publish_date'    => $selectedEdition['publish_date'] ?? null,
                    ];
                }
            }
        } catch (\Exception $e) {

        }

        return [];
    }
}
