<?php

namespace App\Http\Controllers;

use App\UseCases\Dashboard\GetDashboardData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct() {}

    public function index(Request $request, GetDashboardData $getDashboardData)
    {
        $data = $getDashboardData->handle($request->user());

        return Inertia::render('Dashboard/Dashboard', $data);
    }
}
