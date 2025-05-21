<?php

namespace App\Services;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\User;
use App\Repositories\TransactionRepository;
use App\ViewModel\TransactionViewModel;

class DashboardService
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
    }

    public function getDataByUser(User $user): array
    {
        $transactions = $this->transactionRepository->getByUser($user->id);

        return [
            'balance' => (float) $user->balance,
            'transactions' => collect($transactions)->map(fn($t) => (new TransactionViewModel($t, $user->id))->toArray()),
        ];
    }
}
