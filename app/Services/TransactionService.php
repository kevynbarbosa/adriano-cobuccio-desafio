<?php

namespace App\Services;

use App\Jobs\ExecuteTransferJob;
use App\Models\Transaction;
use App\Models\User;
use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    private $userRepository;
    private $transactionRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->transactionRepository = new TransactionRepository();
    }

    public function createTransaction(array $data)
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

    public function executeTransaction(Transaction $transaction)
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
            logger()->error('Error executing transaction', [
                'error' => $th->getMessage(),
                'transaction_id' => $transaction->id,
            ]);
            DB::rollBack();

            $this->transactionRepository->updateStatus($transaction, TransactionStatusEnum::FAILED);

            throw $th;
        }
    }

    public function undoTransaction(Transaction $transaction)
    {
        DB::beginTransaction();
        try {
            $this->userRepository->updateBalance($transaction->payer, $transaction->amount);
            $this->userRepository->updateBalance($transaction->payee, -$transaction->amount);
            $this->transactionRepository->updateStatus($transaction, TransactionStatusEnum::REFUNDED);
            DB::commit();
        } catch (\Throwable $th) {
            logger()->error('Error undoing transaction', [
                'error' => $th->getMessage(),
                'transaction_id' => $transaction->id,
            ]);
            DB::rollBack();
        }
    }

    public function createDeposit(array $data)
    {
        // $transaction = new Transaction();
        // $transaction->user_id = auth()->id;
        // $transaction->amount = $data['amount'];
        // $transaction->description = $data['description'];
        // $transaction->type = TransactionTypeEnum::DEPOSIT;
        // $transaction->status = TransactionStatusEnum::PENDING;
        // $transaction->save();

        // ExecuteTransferJob::dispatch($transaction);
    }

    public function undoDeposit(Transaction $transaction)
    {
        // if ($transaction->status !== TransactionStatusEnum::PENDING) {
        //     throw new \Exception('Transaction cannot be undone');
        // }

        // $transaction->status = TransactionStatusEnum::CANCELED;
        // $transaction->save();
    }
}
