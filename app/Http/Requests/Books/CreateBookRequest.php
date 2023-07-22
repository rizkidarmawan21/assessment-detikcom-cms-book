<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'category_id' => 'required|exists:book_categories,id',
            'description' => 'required|string',
            'number_of_pages' => 'required|integer',
            'cover' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            // if file ready in request check file is pdf but not required
            'file' => 'nullable|file|mimes:pdf|max:2048',

        ];
    }
}
