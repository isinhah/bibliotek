<?php

namespace App\Http\Requests;

use App\DTOs\RegisterDTO;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'O campo nome é obrigatório.',
            'name.string'        => 'O campo nome deve ser um texto válido.',
            'name.max'           => 'O campo nome não pode ter mais de 255 caracteres.',

            'email.required'     => 'O campo e-mail é obrigatório.',
            'email.string'       => 'O campo e-mail deve ser um texto válido.',
            'email.email'        => 'Insira um endereço de e-mail válido.',
            'email.max'          => 'O campo e-mail não pode ter mais de 255 caracteres.',
            'email.unique'       => 'Este e-mail já está cadastrado em nossa base de dados.',

            'password.required'  => 'O campo senha é obrigatório.',
            'password.string'    => 'A senha deve ser um texto válido.',
            'password.min'       => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ];
    }

    public function toDTO(): RegisterDTO
    {
        $validated = $this->validated();

        return new RegisterDTO(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password']
        );
    }
}
