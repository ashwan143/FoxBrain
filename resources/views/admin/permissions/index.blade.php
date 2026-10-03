@extends('admin.layouts.app')

@section('title', 'Permissions')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Permissions
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Manage system permissions and access controls.
        </p>
    </div>

    @if(auth()->user()->hasPermission('permissions.manage'))

        <a href="{{ route('admin.permissions.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Add Permission
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

                    <th class="px-6 py-4 text-left">
                        Permission
                    </th>

                    <th class="px-6 py-4 text-left">
                        Slug
                    </th>

                    <th class="px-6 py-4 text-left">
                        Module
                    </th>

                    <th class="px-6 py-4 text-left">
                        Roles
                    </th>

                    <th class="px-6 py-4 text-right">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y">

                @forelse($permissions as $permission)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">

                            <div class="font-semibold text-gray-800">
                                {{ $permission->name }}
                            </div>

                            @if($permission->description)

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $permission->description }}
                                </div>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $permission->slug }}
                        </td>

                        <td class="px-6 py-4">

                            <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                {{ $permission->module }}
                            </span>

                        </td>

                        <td class="px-6 py-4">
                            {{ $permission->roles_count }}
                        </td>

                        <td class="px-6 py-4 text-right">

                            @if(auth()->user()->hasPermission('permissions.manage'))

                                <a href="{{ route('admin.permissions.edit', $permission) }}"
                                   class="text-blue-600 hover:underline mr-3">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.permissions.destroy', $permission) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Delete this permission?');">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 hover:underline">
                                        Delete
                                    </button>

                                </form>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-6 py-10 text-center text-gray-500">

                            No permissions found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="px-6 py-4 border-t">

        {{ $permissions->links() }}

    </div>

</div>

@endsection