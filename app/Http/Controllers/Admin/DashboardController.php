<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        abort_unless(
            auth()->user()->hasPermission('users.view'),
            403,
            'You do not have permission to access the admin dashboard.'
        );

        $stats = [
            'users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'roles' => Role::count(),
            'permissions' => Permission::count(),
        ];

        $recentActivities = ActivityLog::with('user')
            ->latest('created_at')
            ->take(10)
            ->get();

        $activityStats = [
            'created' => ActivityLog::where('action', 'created')->count(),
            'updated' => ActivityLog::where('action', 'updated')->count(),
            'deleted' => ActivityLog::where('action', 'deleted')->count(),
        ];

        return view(
            'admin.dashboard',
            compact(
                'stats',
                'recentActivities',
                'activityStats'
            )
        );
    }
}