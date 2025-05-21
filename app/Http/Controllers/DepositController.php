<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositStoreRequest;
use App\Models\Transaction;
use App\UseCases\Deposit\CreateDeposit;
use App\UseCases\Deposit\RefundDeposit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepositController extends Controller
{
    public function __construct() {}

    public function create(Request $request)
    {
        return Inertia::render('Deposit/Create', [
            'balance' => (float) $request->user()->balance,
        ]);
    }

    public function store(DepositStoreRequest $request, CreateDeposit $createDeposit)
    {
        $createDeposit->handle($request->validated());

        return redirect()->route('dashboard');
    }

    public function undo(Request $request, Transaction $transaction)
    {
        return Inertia::render('Deposit/Undo', [
            'transaction' => $transaction,
        ]);
    }

    public function undoStore(Request $request, Transaction $transaction, RefundDeposit $refundDeposit)
    {
        $refundDeposit->handle($transaction);

        return redirect()->route('dashboard');
    }
}
