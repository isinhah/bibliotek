<?php

namespace App\Http\Requests;

use App\DTOs\CreateLoanDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => ['required', 'exists:books,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'O identificador do livro é obrigatório para realizar o empréstimo.',
            'book_id.exists'   => 'O livro selecionado não foi encontrado em nosso acervo.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'book_id' => $this->route('book'),
        ]);
    }

    public function toDTO(): CreateLoanDTO
    {
        return new CreateLoanDTO(
            bookId: (int) $this->validated()['book_id'],
            userId: (int) $this->user()->id
        );
    }
}
