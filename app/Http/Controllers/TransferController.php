<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferStoreRequest;
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
        $user = $request->user();
        $user->balance -= $request->amount;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Transfer successful!');
    }

    public function undo(Request $request)
    {
        return Inertia::render('Transfer/Undo');
    }
}
