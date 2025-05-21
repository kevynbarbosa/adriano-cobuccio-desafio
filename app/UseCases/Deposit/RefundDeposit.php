<?php

namespace App\UseCases\Deposit;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Enums\TransactionStatusEnum;
use App\Repositories\UserRepository;
use App\Repositories\TransactionRepository;

class RefundDeposit
{
    private $userRepository;
    private $transactionRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->transactionRepository = new TransactionRepository();
    }

    public function handle(Transaction $transaction)
    {
        DB::beginTransaction();
        try {
            // Poderia criar um Job para realizar a reversão, mas optei para mostrar abordagem diferente
            $this->userRepository->updateBalance($transaction->payee, -$transaction->amount);
            $this->transactionRepository->updateStatus($transaction, TransactionStatusEnum::REFUNDED);
            DB::commit();
        } catch (\Throwable $th) {
            logger()->error('Error refunding deposit transaction', [
                'error' => $th->getMessage(),
                'transaction_id' => $transaction->id,
            ]);
            DB::rollBack();
        }
    }
}
