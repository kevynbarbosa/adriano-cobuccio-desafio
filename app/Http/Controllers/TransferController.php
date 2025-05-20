<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferStoreRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransferController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Transfer/Create', [
            'balance' => (float) $request->user()->balance,
        ]);
    }

    public function store(TransferStoreRequest $request)
    {

        (new TransactionService)->createTransaction(
            $request->validated(),
        );

        return redirect()->route('dashboard');
    }

    public function undo(Request $request)
    {
        return Inertia::render('Transfer/Undo');
    }
}
