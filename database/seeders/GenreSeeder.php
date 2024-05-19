<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path("seeders/data/genres.json"));
        $genres = json_decode($json, true);

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}
