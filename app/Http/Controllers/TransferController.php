<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TransferController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Transfer/Create');
    }

    public function undo(Request $request)
    {
        return Inertia::render('Transfer/Undo');
    }
}
