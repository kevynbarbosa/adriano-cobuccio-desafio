<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getByUser(int $userId): array
    {
        return Transaction::where('payer_id', $userId)
            ->orWhere('payee_id', $userId)
            ->orderBy('date', 'desc')
            ->with(['payer', 'payee'])
            ->get()
            ->all();
    }

    public function getById(int $transactionId): ?Transaction
    {
        return Transaction::find($transactionId);
    }

    public function create(array $data): Transaction
    {
        $transaction = new Transaction();
        $transaction->payer_id = $data['payer_id'];
        $transaction->payee_id = $data['payee_id'];
        $transaction->amount = $data['amount'];
        $transaction->date = $data['date'];
        $transaction->status = $data['status'];
        $transaction->type = $data['type'];
        $transaction->save();

        return $transaction;
    }

    public function undo(int $transactionId): bool
    {
        $transaction = Transaction::find($transactionId);
        if ($transaction) {
            $transaction->status = 'CANCELED';
            $transaction->save();
            return true;
        }

        return false;
    }
}
