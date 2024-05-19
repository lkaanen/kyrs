<?php

namespace App\Services\Book;

use App\Models\Book;

class DeleteBookService
{
    private $book;

    public function deleteBook($id)
    {
        $this->getBookById($id)
            ->deleteImage()
            ->deleteDocument()
            ->deleteAuthors()
            ->deleteGenre()
            ->delete();
    }

    private function delete()
    {
        $this->book->delete();

        return $this;
    }

    private function deleteGenre()
    {
        $this->book->genres()->detach();

        return $this;
    }

    private function deleteAuthors()
    {
        $this->book->authors()->detach();

        return $this;
    }

    private function deleteDocument()
    {
        $path = "uploads/documents/" . $this->book->document;
        if (file_exists(public_path($path))) unlink($path);

        return $this;
    }

    private function deleteImage()
    {
        if (file_exists(public_path($this->book->image))) {
            unlink($this->book->image);
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
