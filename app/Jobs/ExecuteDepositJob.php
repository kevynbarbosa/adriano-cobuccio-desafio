<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\UseCases\Deposit\ExecuteDeposit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExecuteDepositJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Transaction $transaction) {}

    public function handle(): void
    {
        (new ExecuteDeposit)->handle(
            $this->transaction,
        );
    }
}
