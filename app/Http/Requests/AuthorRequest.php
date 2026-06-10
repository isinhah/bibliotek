<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $authorId = $this->route('author');

        $uniqueRule = Rule::unique('authors', 'name');

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $uniqueRule->ignore($authorId);
        } else {
            $uniqueRule->whereNull('deleted_at');
        }

        return [
            'name' => ['required', 'string', 'max:255', $uniqueRule],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome não pode estar vazio.',
            'name.string'   => 'O campo nome deve ser um texto válido.',
            'name.max'      => 'O campo nome não pode ter mais de 255 caracteres.',
            'name.unique'   => 'Este autor já está cadastrado na nossa biblioteca.',
        ];
    }
}
