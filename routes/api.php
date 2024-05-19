<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\Librarian\LibrarianAuthorController;
use App\Http\Controllers\Librarian\LibrarianBookController;
use App\Http\Controllers\Librarian\LibrarianGenreController;
use App\Http\Controllers\Librarian\LibrarianUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('/users/signup', [UserController::class, "store"]);
        $api->post('/users/login', [AuthController::class, "login"]);

        $api->group(['middleware' => 'jwt.auth'], function ($api) {
            $api->post('/token/refresh', [AuthController::class, "refresh"]);
            $api->post('/logout', [AuthController::class, "logout"]);
        });
    });

    $api->get('/books/download-pdf/{filename}', [BookController::class, "downloadPdf"])->middleware(["role:reader"]);

    $api->get("/books", [BookController::class, "index"]);
    $api->get("/books/{id}", [BookController::class, "show"]);

    $api->get("/authors", [AuthorController::class, "index"]);
    $api->get("/authors/{id}", [AuthorController::class, "show"]);

    $api->get("/genres", [GenreController::class, "index"]);
    $api->get("/genres/{id}", [GenreController::class, "show"]);

    $api->group(["prefix" => "admin", "middleware" => ["role:librarian"]], function ($api) {
        $api->post("/books", [LibrarianBookController::class, "store"]);
        $api->post("/books/{id}", [LibrarianBookController::class, "update"]);
        $api->delete("/books/{id}", [LibrarianBookController::class, "destroy"]);

        $api->post("/authors", [LibrarianAuthorController::class, "store"]);
        $api->post("/authors/{id}", [LibrarianAuthorController::class, "update"]);
        $api->delete("/authors/{id}", [LibrarianAuthorController::class, "destroy"]);

        $api->post("/genres", [LibrarianGenreController::class, "store"]);
        $api->patch("/genres/{id}", [LibrarianGenreController::class, "update"]);
        $api->delete("/genres/{id}", [LibrarianGenreController::class, "destroy"]);

        $api->resource("readers", LibrarianUserController::class);
    });

    $api->group(["prefix" => "admin", "middleware" => ["role:admin"]], function ($api) {
        $api->resource("librarians", AdminUserController::class);
    });

    $api->group(["middleware" => "jwt.auth"], function ($api) {
       $api->get("/me", [UserController::class, "me"]);
    });
});
