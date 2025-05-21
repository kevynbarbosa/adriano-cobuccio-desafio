<?php

namespace App\UseCases\Deposit;

use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Jobs\ExecuteDepositJob;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TransactionRepository;

class CreateDeposit
{

    private $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
    }

    public function handle(array $data): void
    {
        try {
            $payload = [
                'payer_id' => null,
                'payee_id' => Auth::id(),
                'amount' => $data['amount'],
                'date' => now(),
                'status' => TransactionStatusEnum::PENDING,
                'type' => TransactionTypeEnum::DEPOSIT,
            ];

            $transaction = $this->transactionRepository->create($payload);
            if (!$transaction) {
                throw new \Exception('Transaction not created');
            }

            ExecuteDepositJob::dispatch($transaction);
        } catch (\Throwable $th) {
            logger()->error('Error creating transaction', [
                'error' => $th->getMessage(),
                'data' => $data,
            ]);
            throw $th;
        }
    }
}
