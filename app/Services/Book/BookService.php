<?php

namespace App\Services\Book;

class BookService
{
    private $getBookService;
    private $storeBookService;
    private $updateBookService;
    private $deleteBookService;

    public function __construct()
    {
        $this->getBookService = new GetBookService();
        $this->storeBookService = new StoreBookService();
        $this->updateBookService = new UpdateBookService();
        $this->deleteBookService = new DeleteBookService();
    }

    public function getAllBook($request)
    {
        return $this->getBookService->getAllBook($request);
    }

    public function storeBook($request)
    {
        return $this->storeBookService->storeBook($request);
    }

    public function getBookById(string $id)
    {
        return $this->getBookService->getBookById($id);
    }

    public function updateBook($request, $id)
    {
        return $this->updateBookService->updateBook($request, $id);
    }

    public function deleteBook($id)
    {
        return $this->deleteBookService->deleteBook($id);
    }
}
