<?php

namespace App\Services\Book;

use App\Models\Book;
use Illuminate\Http\Request;

class GetBookService
{
    private $books;
    private $request;

    public function getBookById(string $id)
    {
        $book = Book::with("authors")
            ->with("genres")
            ->find($id);

        $book->increment("views");

        return $book;
    }

    public function getAllBook(Request $request)
    {
        $this->setRequest($request);

        $this
            ->getAllBooksWithAuthorsAndGenres()
            ->addFilteredBySearch()
            ->addFilteredByAuthors()
            ->addFilteredByGenres()
            ->addOrder();

        return $this->addPagination();
    }

    private function setRequest($request)
    {
        $this->request = $request;
    }

    private function getAllBooksWithAuthorsAndGenres()
    {
        $this->books = Book::query()
            ->with("authors")
            ->with("genres");

        return $this;
    }

    private function addPagination()
    {
        $perPage = $this->request->input("per_page", 10);
        $page = $this->request->input("page", 1);

        return $this->books->paginate($perPage, ["*"], "page", $page);
    }

    private function addFilteredBySearch()
    {
        if ($filteredBySearch = $this->request->search) {
            $place = $request->place ?? "title";

            $this->books->where($place, "like", "%$filteredBySearch%");
        }

        return $this;
    }

    private function addOrder()
    {
        if ($order = $this->request->order) {
            $direction = $request->direction ?? "asc";

            $this->books->orderBy($order, $direction);
        }

        return $this;
    }

    private function addFilteredByAuthors()
    {
        if ($filteredByAuthors = $this->request->authors) {
            $this->books->whereHas("authors", function ($query) use ($filteredByAuthors) {
                $query->whereIn("authors.id", $filteredByAuthors);
            });
        }

        return $this;
    }

    private function addFilteredByGenres()
    {
        if ($filteredByGenres = $this->request->genres) {
            $this->books->whereHas("genres", function ($query) use ($filteredByGenres) {
                $query->whereIn("genres.id", $filteredByGenres);
            });
        }

        return $this;
    }
}
