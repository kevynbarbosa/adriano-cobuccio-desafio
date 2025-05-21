<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index(Request $request)
    {
        $data = $this->dashboardService->getDataByUser($request->user());

        return Inertia::render('Dashboard/Dashboard', $data);
    }
}
