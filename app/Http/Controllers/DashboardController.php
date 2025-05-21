<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::where('payer_id', $request->user()->id)
            ->orWhere('payee_id', $request->user()->id)
            ->orderBy('date', 'desc')
            ->with(['payer', 'payee'])
            ->get();

        return Inertia::render('Dashboard/Dashboard', [
            'balance' => (float) $request->user()->balance,
            'transactions' => $transactions->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'amount' => $transaction->payer_id === Auth::id() ? ($transaction->amount * -1) : $transaction->amount,
                    'date' => $transaction->date,
                    'name' => $transaction->payer_id === Auth::id() ? $transaction->payee->name : $transaction->payer->name,
                    'status' => $transaction->status,
                    'type' => $transaction->type,
                    'subtype' => $transaction->payer_id === Auth::id() ? 'SENT' : 'RECEIVED',
                ];
            }),
        ]);
    }
}
