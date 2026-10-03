<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function index(): View
    {
        abort_unless(
            auth()->user()->hasPermission('users.view'),
            403,
            'You do not have permission to view users.'
        );

        $users = $this->userService->paginate();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        abort_unless(
            auth()->user()->hasPermission('users.create'),
            403,
            'You do not have permission to create users.'
        );

        $roles = Role::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        abort_unless(
            auth()->user()->hasPermission('users.create'),
            403,
            'You do not have permission to create users.'
        );

        $this->userService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user): View
    {
        abort_unless(
            auth()->user()->hasPermission('users.view'),
            403,
            'You do not have permission to view users.'
        );

        $user->load('role');

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        abort_unless(
            auth()->user()->hasPermission('users.edit'),
            403,
            'You do not have permission to edit users.'
        );

        $roles = Role::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.users.edit',
            compact('user', 'roles')
        );
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('users.edit'),
            403,
            'You do not have permission to edit users.'
        );

        $this->userService->update(
            $user,
            $request->validated()
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless(
            auth()->user()->hasPermission('users.delete'),
            403,
            'You do not have permission to delete users.'
        );

        try {

            $this->userService->delete($user);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User deleted successfully.');

        } catch (\RuntimeException $exception) {

            return redirect()
                ->route('admin.users.index')
                ->with('error', $exception->getMessage());
        }
    }
}