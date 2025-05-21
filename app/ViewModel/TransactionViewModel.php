<?php

namespace App\ViewModel;

use App\Models\Transaction;

class TransactionViewModel
{
    public function __construct(public Transaction $transaction, public int $currentUserId) {}

    public function toArray(): array
    {
        return [
            'id' => $this->transaction->id,
            'amount' => $this->transaction->payer_id === $this->currentUserId ? -$this->transaction->amount : $this->transaction->amount,
            'date' => $this->transaction->date,
            'name' => $this->transaction->payer_id === $this->currentUserId ? $this->transaction->payee->name : $this->transaction->payer->name,
            'status' => $this->transaction->status,
            'type' => $this->transaction->type,
            'subtype' => $this->transaction->payer_id === $this->currentUserId ? 'SENT' : 'RECEIVED',
        ];
    }
}
