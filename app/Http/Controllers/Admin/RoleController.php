<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Admin\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService
    ) {
    }

    public function index(): View
    {
        abort_unless(
            auth()->user()->hasPermission('roles.view'),
            403,
            'You do not have permission to view roles.'
        );

        $roles = $this->roleService->paginate();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        abort_unless(
            auth()->user()->hasPermission('roles.create'),
            403,
            'You do not have permission to create roles.'
        );

        $permissions = Permission::orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        return view(
            'admin.roles.create',
            compact('permissions')
        );
    }

    public function store(
        StoreRoleRequest $request
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('roles.create'),
            403,
            'You do not have permission to create roles.'
        );

        $this->roleService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit(Role $role): View
    {
        abort_unless(
            auth()->user()->hasPermission('roles.edit'),
            403,
            'You do not have permission to edit roles.'
        );

        $permissions = Permission::orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        $role->load('permissions');

        return view(
            'admin.roles.edit',
            compact('role', 'permissions')
        );
    }

    public function update(
        UpdateRoleRequest $request,
        Role $role
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('roles.edit'),
            403,
            'You do not have permission to edit roles.'
        );

        $this->roleService->update(
            $role,
            $request->validated()
        );

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        abort_unless(
            auth()->user()->hasPermission('roles.delete'),
            403,
            'You do not have permission to delete roles.'
        );

        try {
            $this->roleService->delete($role);

            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Role deleted successfully.');
        } catch (\RuntimeException $exception) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', $exception->getMessage());
        }
    }
}