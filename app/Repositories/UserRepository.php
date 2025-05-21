<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getById(int $userId): ?User
    {
        return User::find($userId);
    }

    public function getByAccountAndDocumento(string $accountNumber, string $documentNumber): ?User
    {
        return User::where('account_number', $accountNumber)
            ->where('document_number', $documentNumber)
            ->first();
    }

    public function updateBalance(User $user, float $amount): bool
    {
        $user->balance += $amount;
        return $user->save();
    }
}
