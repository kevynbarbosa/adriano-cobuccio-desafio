<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DepositController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Deposit/Create');
    }

    public function undo(Request $request)
    {
        return Inertia::render('Deposit/Undo');
    }
}
