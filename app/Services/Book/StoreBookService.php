<?php

namespace App\Services\Book;

use App\Models\Book;
use App\Services\CoreService;

class StoreBookService extends CoreService
{
    private $request;
    private $image;
    private $documentName;
    private $book;

    public function storeBook($request)
    {
        $this->setRequest($request);

        $this->imageUpload();
        $this->documentUpload();

        $this->createBook()
            ->setAuthors()
            ->setGenres();

        return $this->book;
    }

    private function setRequest($request)
    {
        $this->request = $request;
    }

    private function imageUpload()
    {
        $this->image = "uploads/images/" . $this
                ->fileUpload(
                    $this->request->file("image"),
                    "images",
                    $this->request->title
                );

        return $this;
    }

    private function documentUpload()
    {
        $this->documentName = $this
            ->fileUpload(
                $this->request->file("document"),
                "documents",
                $this->request->title
            );

        return $this;
    }

    private function setGenres()
    {
        $this->book->genres()->attach($this->request->genres);
        $this->book->genres = $this->book->genres()->get();

        return $this;
    }

    private function setAuthors()
    {
        $this->book->authors()->attach($this->request->authors);
        $this->book->authors = $this->book->authors()->get();

        return $this;
    }

    private function createBook()
    {
        $this->book = Book::create([
            "title" => $this->request->input("title"),
            "description" => $this->request->input("description"),
            "authors" => $this->request->authors,
            "genres" => $this->request->genres,
            "image" => $this->image,
            "document" => $this->documentName
        ]);

        return $this;
    }
}
