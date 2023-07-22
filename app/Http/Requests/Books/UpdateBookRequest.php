<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'cover' => 'nullable|file|mimes:jpg,jpeg,png',
            // if file ready in request check file is pdf but not required
            'file' => 'nullable|file|mimes:pdf',
        ];
    }
}
