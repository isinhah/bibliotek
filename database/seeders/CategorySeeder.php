<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Literature',
            'Psychology',
            'Horror',
            'Fantasy',
            'Poetry',
            'Science Fiction',
            'Thriller',
            'Romance',
            'Historical Fiction',
        ];

        foreach ($categories as $categoryName) {
            Category::updateOrCreate(
                ['name' => $categoryName]
            );
        }
    }
}
