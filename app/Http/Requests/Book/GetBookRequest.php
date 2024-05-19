<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetBookRequest extends FormRequest
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
        return [
            "authors" => ["array"],
            "authors.*" => ["numeric"],
            "genres" => ["array"],
            "genres.*" => ["numeric"],
            "search" => ["string"],
            "place" => Rule::in(["description", "title"]),
            "order" => Rule::in([
                "description",
                "title", "created_at",
                "updated_at",
                "downloads",
                "views"
            ]),
            "direction" => Rule::in(["asc", "desc"]),
        ];
    }
}
