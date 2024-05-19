<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path("seeders/data/books.json"));
        $books = json_decode($json, true);

        foreach ($books as $book) {
            $bookModel = Book::create([
                "title" => $book["title"],
                "image" => $book["image"],
                "document" => $book["document"],
                "description" => $book["description"],
            ]);

            $authorIds = [];
            foreach ($book["authors"] as $authorName) {
                $author = Author::where("full_name", $authorName)->first();

                $authorIds[] = $author->id;
            }

            $genreIds = [];
            foreach ($book["genres"] as $genreName) {
                $genre = Genre::where("title", $genreName)->first();

                $genreIds[] = $genre->id;
            }

            $bookModel->authors()->attach($authorIds);
            $bookModel->genres()->attach($genreIds);
        }
    }
}
