<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path("seeders/data/author.json"));
        $authors = json_decode($json, true);

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
