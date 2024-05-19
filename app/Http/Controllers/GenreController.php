<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Genre\GetGenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetGenreRequest $request)
    {
        $genres = Genre::query();

        if ($search = $request->search) {
            $place = $request->input("place", "title");
            $genres = $genres->where($place, "like", "%$search%");
        }

        if ($order = $request->order) {
            $direction = $request->input("direction", "asc");
            $genres = $genres->orderBy($order, $direction);
        }

        $perPage = $request->input("per_page", 10);
        $page = $request->input("page", 1);

        $genres = $genres->paginate($perPage, ["*"], "page", $page);

        return response()->json($genres);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Genre::find($id);

        return response()->json($author);
    }
}
