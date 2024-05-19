<?php

namespace App\Http\Requests\Genre;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetGenreRequest extends FormRequest
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
            "place" => Rule::in(["description", "title"]),
            "order" => Rule::in(["description", "title"]),
            "direction" => Rule::in(["asc", "desc"])
        ];
    }
}
