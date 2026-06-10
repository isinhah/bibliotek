<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category');

        $uniqueRule = Rule::unique('categories', 'name');

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $uniqueRule->ignore($categoryId);
        } else {
            $uniqueRule->whereNull('deleted_at');
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $uniqueRule
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome não pode estar vazio.',
            'name.string'   => 'O campo nome deve ser um texto válido.',
            'name.max'      => 'O campo nome não pode ter mais de 255 caracteres.',
            'name.unique'   => 'Essa categoria já existe na nossa biblioteca.',
        ];
    }
}
