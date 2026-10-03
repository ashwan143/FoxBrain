@extends('admin.layouts.app')

@section('title', 'Roles')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Roles
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Manage system roles and permissions.
        </p>
    </div>

    @if(auth()->user()->hasPermission('roles.create'))
        <a href="{{ route('admin.roles.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Add Role
        </a>
    @endif
</div>

@if(session('success'))
    <div class="mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-3">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 rounded-lg bg-red-100 text-red-800 px-4 py-3">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left">Role</th>
                    <th class="px-6 py-4 text-left">Slug</th>
                    <th class="px-6 py-4 text-left">Users</th>
                    <th class="px-6 py-4 text-left">Permissions</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($roles as $role)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">
                                {{ $role->name }}
                            </div>

                            @if($role->description)
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $role->description }}
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $role->slug }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->users_count }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->permissions_count }}
                        </td>

                        <td class="px-6 py-4">

                            @if($role->is_active)
                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                    Inactive
                                </span>
                            @endif

                        </td>

                        <td class="px-6 py-4 text-right">

                            @if(auth()->user()->hasPermission('roles.edit'))

                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="text-blue-600 hover:underline mr-3">
                                    Edit
                                </a>

                            @endif

                            @if(
                                auth()->user()->hasPermission('roles.delete')
                                && $role->slug !== 'super-admin'
                            )

                                <form action="{{ route('admin.roles.destroy', $role) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Delete this role?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:underline">
                                        Delete
                                    </button>

                                </form>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6"
                            class="px-6 py-10 text-center text-gray-500">
                            No roles found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="px-6 py-4 border-t">
        {{ $roles->links() }}
    </div>

</div>

@endsection