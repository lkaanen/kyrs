<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "views",
        "document",
        "image"
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, "book_authors");
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, "book_genres");
    }
}
