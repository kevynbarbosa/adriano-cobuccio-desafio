<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\UseCases\Transfer\ExecuteTransfer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExecuteTransferJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Transaction $transaction)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new ExecuteTransfer)->handle(
            $this->transaction,
        );
    }
}
