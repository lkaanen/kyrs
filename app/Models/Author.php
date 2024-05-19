<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        "full_name",
        "description",
        "image"
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, "book_authors");
    }
}
