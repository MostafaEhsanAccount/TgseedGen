<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'tenantCount' => Tenant::count(),
            'userCount' => User::withoutGlobalScopes()->count(),
        ]);
    }
}
