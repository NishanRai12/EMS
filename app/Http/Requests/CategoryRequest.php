<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * jkb the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cat_name' => 'required|min:3',
            'percentage' => 'required|max:100|min:0|numeric',
        ];
    }
    public function messages(): array{
        return [
            'cat_name.required' => 'The Category name is required',
            'cat_name.min' => 'The Category name must be at least 3 characters',
        ];
    }
}
