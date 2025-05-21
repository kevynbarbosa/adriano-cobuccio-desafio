<?php

namespace App\UseCases\Deposit;

use App\Models\Transaction;

class ExecuteDeposit
{
    public function __construct() {}

    public function handle(Transaction $transaction): void {}
}
