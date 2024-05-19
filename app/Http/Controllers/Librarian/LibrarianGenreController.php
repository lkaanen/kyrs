<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Http\Requests\Genre\GetGenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;

class LibrarianGenreController extends Controller
{
    /**
     * Store a newly created resource in storage./
     */
    public function store(Request $request)
    {
        $author = Genre::create($request->all());

        return response()->json($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $genre = Genre::find($id);
        if (!$genre) return response()->json(["message" => "Genre not found"]);

        $genre->update($request->all());

        return response()->json($genre);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::find($id);
        if (!$genre) return response()->json(["message" => "Genre not found"]);

        $genre->delete();

        return response()->json(["message" => "Genre successfully removed"]);
    }
}
