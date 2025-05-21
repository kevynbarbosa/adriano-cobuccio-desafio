<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\UseCases\Transfer\CreateTransfer;
use App\Http\Requests\TransferStoreRequest;
use App\UseCases\Transfer\RefundTransfer;

class TransferController extends Controller
{
    public function __construct() {}


    public function create(Request $request)
    {
        return Inertia::render('Transfer/Create', [
            'balance' => (float) $request->user()->balance,
        ]);
    }

    public function store(TransferStoreRequest $request, CreateTransfer $createTransfer)
    {
        $createTransfer->handle($request->validated());

        return redirect()->route('dashboard');
    }

    public function undo(Request $request, Transaction $transaction)
    {
        return Inertia::render('Transfer/Undo', [
            'transaction' => $transaction,
        ]);
    }

    public function undoStore(Request $request, Transaction $transaction, RefundTransfer $refundTransfer)
    {
        $refundTransfer->handle($transaction);

        return redirect()->route('dashboard');
    }
}
