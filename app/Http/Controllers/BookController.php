<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\GetBookRequest;
use App\Models\Book;
use App\Services\Book\BookService;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Downloads the requested file
     */
    public function downloadPdf($filename)
    {
        $filePath = public_path('uploads/documents/' . $filename);

        if (file_exists($filePath)) {
            $book = Book::where("document", "=", $filename)->first();
            $book->increment("downloads");

            return response()->download($filePath);
        }

        return response()->json(['message' => 'File not found'], 404);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetBookRequest $request)
    {
        $books = $this->bookService->getAllBook($request);

        return response()->json($books);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = $this->bookService->getBookById($id);

        return response()->json($book);
    }
}
