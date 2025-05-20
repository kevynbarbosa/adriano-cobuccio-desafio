<?php

namespace App\Services;

use App\Jobs\ExecuteTransferJob;
use App\Models\Transaction;
use App\Models\User;
use App\TransactionStatusEnum;
use App\TransactionTypeEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function __construct() {}

    public function createTransaction(array $data)
    {
        try {
            $payee = User::where('account_number', $data['account'])
                ->where('document_number', $data['document'])
                ->firstOrFail();

            $transaction = new Transaction();
            $transaction->payer_id = Auth::id();
            $transaction->payee_id = $payee->id;
            $transaction->amount = $data['amount'];
            $transaction->date = now();
            $transaction->type = TransactionTypeEnum::TRANSFER;
            $transaction->status = TransactionStatusEnum::PENDING;
            $transaction->save();

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
            $payer = User::findOrFail($transaction->payer_id);
            $payee = User::findOrFail($transaction->payee_id);
            $payer->balance -= $transaction->amount;
            $payee->balance += $transaction->amount;

            $payer->save();
            $payee->save();

            $transaction->status = TransactionStatusEnum::COMPLETED;
            $transaction->save();
            DB::commit();
        } catch (\Throwable $th) {
            logger()->error('Error executing transaction', [
                'error' => $th->getMessage(),
                'transaction_id' => $transaction->id,
            ]);
            DB::rollBack();

            $transaction->status = TransactionStatusEnum::FAILED;
            $transaction->save();
            throw $th;
        }
    }

    public function undoTransaction(Transaction $transaction)
    {
        // if ($transaction->status !== TransactionStatusEnum::PENDING) {
        //     throw new \Exception('Transaction cannot be undone');
        // }

        // $transaction->status = TransactionStatusEnum::CANCELED;
        // $transaction->save();
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
