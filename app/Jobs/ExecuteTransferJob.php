<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\UseCases\Transfer\ExecuteTransfer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExecuteTransferJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Transaction $transaction) {}

    public function handle(): void
    {
        (new ExecuteTransfer)->handle(
            $this->transaction,
        );
    }
}
