<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryPercentageRequest extends FormRequest
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
           'categoryPercentage' => ['required', 'array'],
           'categoryPercentage.*' => ['required', 'integer', 'min:0', 'max:100'],
       ];
    }
    public function attributes(): array{
        return [
            'categoryPercentage.*' => 'Percentage',
        ];
    }
}
