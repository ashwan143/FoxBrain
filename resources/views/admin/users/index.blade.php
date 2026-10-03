@extends('admin.layouts.app')

@section('title', 'Users')
@section('page_title', 'Users')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Users
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Manage system users and their roles.
            </p>
        </div>

        @can('create', App\Models\User::class)
            <a href="{{ route('admin.users.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add User
            </a>
        @endcan

    </div>


    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>

                        <th class="text-left px-6 py-4 font-semibold">
                            Name
                        </th>

                        <th class="text-left px-6 py-4 font-semibold">
                            Email
                        </th>

                        <th class="text-left px-6 py-4 font-semibold">
                            Role
                        </th>

                        <th class="text-left px-6 py-4 font-semibold">
                            Status
                        </th>

                        <th class="text-right px-6 py-4 font-semibold">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($users as $user)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-800">
                                    {{ $user->name }}
                                </div>

                                @if($user->phone)
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $user->phone }}
                                    </div>
                                @endif

                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4">

                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                    {{ $user->role?->name ?? 'No Role' }}
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                @php
                                    $statusClasses = [
                                        'active' => 'bg-green-100 text-green-700',
                                        'inactive' => 'bg-gray-100 text-gray-700',
                                        'suspended' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp

                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$user->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($user->status) }}
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    @can('update', $user)

                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                            Edit
                                        </a>

                                    @endcan


                                    @can('delete', $user)

                                        @if($user->id !== auth()->id() && !$user->isSuperAdmin())

                                            <form method="POST"
                                                  action="{{ route('admin.users.destroy', $user) }}"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="px-3 py-1.5 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                                    Delete
                                                </button>

                                            </form>

                                        @endif

                                    @endcan

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-6 py-10 text-center text-gray-500">

                                No users found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($users->hasPages())

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>

        @endif

    </div>

</div>

@endsection