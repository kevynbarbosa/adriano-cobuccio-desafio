<?php

namespace App\Interfaces;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function getByUser(int $userId): array;

    public function getById(int $transactionId): ?Transaction;

    public function create(array $data): Transaction;

    public function undo(int $transactionId): bool;
}
