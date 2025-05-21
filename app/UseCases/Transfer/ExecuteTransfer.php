<?php

namespace App\UseCases\Transfer;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Enums\TransactionStatusEnum;
use App\Repositories\UserRepository;
use App\Repositories\TransactionRepository;

class ExecuteTransfer
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
            $payer = $this->userRepository->getById($transaction->payer_id);
            $payee = $this->userRepository->getById($transaction->payee_id);

            $this->userRepository->updateBalance($payer, -$transaction->amount);
            $this->userRepository->updateBalance($payee, $transaction->amount);
            $this->transactionRepository->updateStatus($transaction, TransactionStatusEnum::COMPLETED);

            DB::commit();
        } catch (\Throwable $th) {
            logger()->error('Error executing transfer transaction', [
                'error' => $th->getMessage(),
                'transaction_id' => $transaction->id,
            ]);
            DB::rollBack();

            $this->transactionRepository->updateStatus($transaction, TransactionStatusEnum::FAILED);

            throw $th;
        }
    }
}
