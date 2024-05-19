<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\GetAuthorRequest;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Models\Author;
use App\Services\Author\AuthorService;
use Illuminate\Http\Request;

class LibrarianAuthorController extends Controller
{
    private $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Store a newly created resource in storage./
     */
    public function store(StoreAuthorRequest $request)
    {
        $image = $this->authorService
            ->fileUpload($request->file("image"), "images", $request->full_name);

        $author = Author::create([
            "full_name" => $request->input("full_name"),
            "description" => $request->input("description"),
            "image" => "uploads/images/" . $image
        ]);

        return response()->json($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $author = Author::find($id);

        if (!$author) return response()->json(["message" => "Author not found"]);

        if ($file = $request->file("image")) {
            if (file_exists(public_path($author->image))) unlink($author->image);

            $title = $request->title ?? $author->full_name;
            $fileName = $this->authorService->fileUpload($file, "images", $title);
            $imageUrl = "uploads/images/" . $fileName;
        }

        $author->update([
            "full_name" => $request->input("full_name", $author->full_name),
            "description" => $request->input("description", $author->description),
            "image" => $imageUrl ?? $author->image
        ]);

        $author->books = $author->books()->with("genres")->get();

        return response()->json($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = Author::find($id);

        if (!$author) return response()->json(["message" => "Author not found"]);

        if (file_exists(public_path($author->image))) unlink($author->image);

        $author->books()->detach();
        $author->delete();

        return response()->json(["message" => "Запись успешно удалена"]);
    }
}
