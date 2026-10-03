<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\Admin\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService
    ) {
    }

    public function index(): View
    {
        abort_unless(
            auth()->user()->hasPermission('permissions.view'),
            403,
            'You do not have permission to view permissions.'
        );

        $permissions = $this->permissionService->paginate();

        return view(
            'admin.permissions.index',
            compact('permissions')
        );
    }

    public function create(): View
    {
        abort_unless(
            auth()->user()->hasPermission('permissions.manage'),
            403,
            'You do not have permission to manage permissions.'
        );

        return view('admin.permissions.create');
    }

    public function store(
        StorePermissionRequest $request
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('permissions.manage'),
            403,
            'You do not have permission to manage permissions.'
        );

        $this->permissionService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission): View
    {
        abort_unless(
            auth()->user()->hasPermission('permissions.manage'),
            403,
            'You do not have permission to manage permissions.'
        );

        return view(
            'admin.permissions.edit',
            compact('permission')
        );
    }

    public function update(
        UpdatePermissionRequest $request,
        Permission $permission
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('permissions.manage'),
            403,
            'You do not have permission to manage permissions.'
        );

        $this->permissionService->update(
            $permission,
            $request->validated()
        );

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(
        Permission $permission
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('permissions.manage'),
            403,
            'You do not have permission to manage permissions.'
        );

        try {
            $this->permissionService->delete($permission);

            return redirect()
                ->route('admin.permissions.index')
                ->with('success', 'Permission deleted successfully.');

        } catch (\RuntimeException $exception) {

            return redirect()
                ->route('admin.permissions.index')
                ->with('error', $exception->getMessage());
        }
    }
}