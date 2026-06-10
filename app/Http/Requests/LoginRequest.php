<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTOs\LoginDTO;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'Insira um endereço de e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
            'password.string'   => 'A senha fornecida é inválida.',
        ];
    }

    public function toDTO(): LoginDTO
    {
        $validated = $this->validated();

        return new LoginDTO(
            email: $validated['email'],
            password: $validated['password'],
            remember: (bool) ($validated['remember'] ?? false)
        );
    }
}
