<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\GetAuthorRequest;
use App\Models\Author;
use App\Services\Author\AuthorService;

class AuthorController extends Controller
{
    private $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetAuthorRequest $request)
    {
        $authors = Author::query()
            ->with("books", function ($query) {
                $query->with("genres");
            });

        if ($search = $request->search) {
            $place = $request->place ?? "full_name";
            $authors = $authors->where($place, "like", "%$search%");
        }

        if ($order = $request->order) {
            $direction = $request->direction ?? "asc";
            $authors = $authors->orderBy($order, $direction);
        }

        $perPage = $request->input("per_page", 10);
        $page = $request->input("page", 1);

        $authors = $authors->paginate($perPage, ["*"], "page", $page);

        return response()->json($authors);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::with("books.genres")->where("id", $id)->first();

        return response()->json($author);
    }
}
