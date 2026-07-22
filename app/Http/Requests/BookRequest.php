<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'stock'        => ['required', 'integer', 'min:0'],
            'author_id'    => ['required', 'exists:authors,id'],
            'category_id'  => ['required', 'exists:categories,id'],
            'isbn'         => ['nullable', 'string', 'max:50'],
            'publisher'    => ['nullable', 'string', 'max:255'],
            'publish_date' => ['nullable', 'string', 'max:50'],
            'pages'        => ['nullable', 'integer', 'min:1'],
            'rating'       => ['nullable', 'numeric', 'min:0', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'O título do livro é obrigatório.',
            'stock.required'       => 'Informe a quantidade em estoque.',
            'stock.integer'        => 'O estoque deve ser um número inteiro.',
            'stock.min'            => 'O estoque não pode ser negativo.',
            'author_id.required'   => 'Selecione um autor.',
            'author_id.exists'     => 'O autor selecionado é inválido.',
            'category_id.required' => 'Selecione uma categoria.',
            'category_id.exists'   => 'A categoria selecionada é inválida.',
        ];
    }
}
