<?php

namespace App\Http\Requests\Book;

use App\Models\Author;
use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $authorIds = Author::pluck("id")->toArray();
        $genreIds = Genre::pluck("id")->toArray();

        return [
            "title" => ["string", "min:3", "max:128"],
            "description" => ["string", "min:40", "max:1000"],
            "authors" => ["array"],
            "authors.*" => [Rule::in($authorIds)],
            "genres" => ["array"],
            "genres.*" => Rule::in($genreIds),
            "image"  => 'mimes:png,jpg,jpeg,webp|max:5048',
            "document" => 'mimes:doc,docx,pdf,txt|max:5048',
        ];
    }
}
