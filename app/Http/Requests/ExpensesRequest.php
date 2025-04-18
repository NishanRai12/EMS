<?php

namespace App\Http\Requests;

use App\Rules\DateValidation;
use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
            'title'=>['required'],
            'description'=>['required','max:255'],
            'amount'=>['required','numeric','min:1'],
            'date'=>['required','date',new DateValidation],
        ];
    }

}
