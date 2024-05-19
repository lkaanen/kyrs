<?php

namespace App\Services\Book;

use App\Models\Book;
use App\Services\CoreService;

class UpdateBookService extends CoreService
{
    private $request;
    private $book;
    private $image;
    private $document;

    public function updateBook($request, $id)
    {
        $this->setRequest($request);

        $this->getBookById($id)
            ->imageUpdate()
            ->documentUpdate()
            ->updateAuthors()
            ->updateGenres()
            ->update()
            ->setAuthors()
            ->setGenres();

        return $this->book;
    }

    private function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    private function setGenres()
    {
        $this->book->genres = $this->book->genres()->get();

        return $this;
    }

    private function setAuthors()
    {
        $this->book->authors = $this->book->authors()->get();

        return $this;
    }

    private function update()
    {
        $this->book->update([
            "title" => $this->request->input("title") ?? $this->book->title,
            "description" => $this->request->input("description") ?? $this->book->description,
            "authors" => $this->request->authors ?? $this->book->authors,
            "genres" => $this->request->genres ?? $this->book->genres,
            "image" => $this->image ?? $this->book->image,
            "document" => $this->document ?? $this->book->document
        ]);

        return $this;
    }

    private function updateGenres()
    {
        if ($genres = $this->request->genres) {
            $this->book->genres()->detach();
            $this->book->genres()->attach($genres);
        }

        return $this;
    }

    private function updateAuthors()
    {
        if ($authors = $this->request->authors) {
            $this->book->authors()->detach();
            $this->book->authors()->attach($authors);
        }

        return $this;
    }

    private function documentUpdate()
    {
        if ($file = $this->request->file("document")) {
            $path = "uploads/documents/" . $this->book->document;
            if (file_exists(public_path($path))) unlink($path);

            $title = $this->request->title ?? $this->book->title;
            $fileName = $this->fileUpload($file, "documents", $title);

            $this->document = $fileName;
        }

        return $this;
    }

    private function imageUpdate()
    {
        if ($file = $this->request->file("image")) {
            if (file_exists(public_path($this->book->image))) {
                unlink($this->book->image);
            }

            $title = $this->request->title ?? $this->book->title;
            $fileName = $this->fileUpload($file, "images", $title);
            $image_url = "uploads/images/" . $fileName;

            $this->image = $image_url;
        }

        return $this;
    }

    private function getBookById($id)
    {
        $book = Book::find($id);
        if (!$book) return response()->json(["message" => "Book not found"]);

        $this->book = $book;

        return $this;
    }
}
