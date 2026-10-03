<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function __construct(
        private readonly ActivityLogService $activityLogService
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless(
            auth()->user()->hasPermission('activity_logs.view'),
            403,
            'You do not have permission to view activity logs.'
        );

        $module = $request->input('module');
        $action = $request->input('action');
        $search = $request->input('search');

        $logs = $this->activityLogService->paginate(
            perPage: 20,
            module: $module,
            action: $action,
            search: $search
        );

        $modules = $this->activityLogService->modules();

        $actions = $this->activityLogService->actions();

        return view(
            'admin.activity-logs.index',
            compact(
                'logs',
                'modules',
                'actions',
                'module',
                'action',
                'search'
            )
        );
    }
}