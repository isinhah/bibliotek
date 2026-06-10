<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'stock.required' => 'O campo estoque é obrigatório.',
            'stock.integer'  => 'O estoque deve ser um número inteiro válido.',
            'stock.min'      => 'O estoque não pode ser um número negativo.',
        ];
    }
}
