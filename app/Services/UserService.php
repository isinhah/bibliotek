<?php

namespace App\Services;

use App\Exceptions\UserHasActiveLoansException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $data): User
    {
        if (isset($data['password']) && !Hash::needsRehash($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = User::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function delete(int $id): bool
    {
        $user = User::findOrFail($id);

        $hasActiveLoans = $user->loans()
            ->whereIn('status', ['PENDING', 'ACTIVE', 'OVERDUE'])
            ->exists();

        if ($hasActiveLoans) {
            throw new UserHasActiveLoansException("Não é possível eliminar o usuário '{$user->name}' porque ele possui empréstimos pendentes, ativos ou em atraso.");
        }

        return $user->delete();
    }
}
