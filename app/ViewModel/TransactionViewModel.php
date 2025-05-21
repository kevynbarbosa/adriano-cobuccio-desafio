<?php

namespace App\ViewModel;

use App\Models\Transaction;

class TransactionViewModel
{
    public function __construct(public Transaction $transaction, public int $currentUserId) {}

    private function getName(): string
    {
        if ($this->transaction->type === 'DEPOSIT') {
            return 'Depósito';
        }

        if ($this->transaction->payer_id === $this->currentUserId) {
            return $this->transaction->payee->name;
        }

        return $this->transaction->payer->name;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->transaction->id,
            'amount' => $this->transaction->payer_id === $this->currentUserId ? -$this->transaction->amount : $this->transaction->amount,
            'date' => $this->transaction->date,
            'name' => $this->getName(),
            'status' => $this->transaction->status,
            'type' => $this->transaction->type,
            'subtype' => $this->transaction->payer_id === $this->currentUserId ? 'SENT' : 'RECEIVED',
        ];
    }
}
