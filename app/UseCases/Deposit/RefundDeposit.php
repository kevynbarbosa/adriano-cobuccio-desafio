<?php

namespace App\UseCases\Deposit;

use App\Models\Transaction;

class RefundDeposit
{
    public function __construct() {}

    public function handle(Transaction $transaction): void {}
}
