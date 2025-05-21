<?php

namespace App\UseCases\Dashboard;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\User;
use App\ViewModel\TransactionViewModel;
use App\Repositories\TransactionRepository;

class GetDashboardData
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
    }

    public function handle(User $user): array
    {
        $transactions = $this->transactionRepository->getByUser($user->id);

        return [
            'balance' => (float) $user->balance,
            'transactions' => collect($transactions)->map(fn($t) => (new TransactionViewModel($t, $user->id))->toArray()),
        ];
    }
}
