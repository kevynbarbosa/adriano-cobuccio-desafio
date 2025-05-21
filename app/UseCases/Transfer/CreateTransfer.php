<?php

namespace App\UseCases\Transfer;

use App\Jobs\ExecuteTransferJob;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TransactionRepository;

class CreateTransfer
{

    private $userRepository;
    private $transactionRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->transactionRepository = new TransactionRepository();
    }

    public function handle(array $data)
    {
        try {
            $payee = $this->userRepository->getByAccountAndDocumento($data['account'], $data['document']);
            if (!$payee) {
                throw new \Exception('User not found');
            }

            $payload = [
                'payer_id' => Auth::id(),
                'payee_id' => $payee->id,
                'amount' => $data['amount'],
                'date' => now(),
                'status' => TransactionStatusEnum::PENDING,
                'type' => TransactionTypeEnum::TRANSFER,
            ];

            $transaction = $this->transactionRepository->create($payload);
            if (!$transaction) {
                throw new \Exception('Transaction not created');
            }

            ExecuteTransferJob::dispatch($transaction);
        } catch (\Throwable $th) {
            logger()->error('Error creating transaction', [
                'error' => $th->getMessage(),
                'data' => $data,
            ]);
            throw $th;
        }
    }
}
