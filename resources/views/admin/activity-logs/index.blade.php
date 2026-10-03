@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('content')

<div class="mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Activity Logs
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Monitor administrative activities and system changes.
        </p>
    </div>

</div>


{{-- Filters --}}

<div class="bg-white rounded-xl shadow-sm p-5 mb-6">

    <form
        method="GET"
        action="{{ route('admin.activity-logs.index') }}"
    >

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- Search --}}

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="User, email, description, IP..."
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

            </div>


            {{-- Module --}}

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Module
                </label>

                <select
                    name="module"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        All Modules
                    </option>

                    @foreach($modules as $item)

                        <option
                            value="{{ $item }}"
                            {{ $module === $item ? 'selected' : '' }}
                        >
                            {{ ucwords(str_replace('_', ' ', $item)) }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Action --}}

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Action
                </label>

                <select
                    name="action"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        All Actions
                    </option>

                    @foreach($actions as $item)

                        <option
                            value="{{ $item }}"
                            {{ $action === $item ? 'selected' : '' }}
                        >
                            {{ ucfirst($item) }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Buttons --}}

            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                >
                    Filter
                </button>

                <a
                    href="{{ route('admin.activity-logs.index') }}"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </div>

    </form>

</div>


{{-- Logs Table --}}

<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 border-b">

                <tr>

                    <th class="px-6 py-4 text-left">
                        Date / Time
                    </th>

                    <th class="px-6 py-4 text-left">
                        User
                    </th>

                    <th class="px-6 py-4 text-left">
                        Module
                    </th>

                    <th class="px-6 py-4 text-left">
                        Action
                    </th>

                    <th class="px-6 py-4 text-left">
                        Description
                    </th>

                    <th class="px-6 py-4 text-left">
                        IP Address
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y">

                @forelse($logs as $log)

                    <tr class="hover:bg-gray-50">

                        {{-- Date --}}

                        <td class="px-6 py-4 whitespace-nowrap">

                            <div class="font-medium text-gray-800">
                                {{ $log->created_at?->format('d-m-Y') }}
                            </div>

                            <div class="text-xs text-gray-500">
                                {{ $log->created_at?->format('h:i A') }}
                            </div>

                        </td>


                        {{-- User --}}

                        <td class="px-6 py-4">

                            @if($log->user)

                                <div class="font-medium text-gray-800">
                                    {{ $log->user->name }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ $log->user->email }}
                                </div>

                            @else

                                <span class="text-gray-400">
                                    System
                                </span>

                            @endif

                        </td>


                        {{-- Module --}}

                        <td class="px-6 py-4">

                            <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                {{ ucwords(str_replace('_', ' ', $log->module ?? 'General')) }}
                            </span>

                        </td>


                        {{-- Action --}}

                        <td class="px-6 py-4">

                            @php
                                $actionClass = match($log->action) {
                                    'created' => 'bg-green-100 text-green-700',
                                    'updated' => 'bg-yellow-100 text-yellow-700',
                                    'deleted' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="px-2 py-1 rounded-full text-xs {{ $actionClass }}">
                                {{ ucfirst($log->action) }}
                            </span>

                        </td>


                        {{-- Description --}}

                        <td class="px-6 py-4 text-gray-700">
                            {{ $log->description }}
                        </td>


                        {{-- IP --}}

                        <td class="px-6 py-4 text-gray-500">
                            {{ $log->ip_address ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-6 py-10 text-center text-gray-500"
                        >
                            No activity logs found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}

    <div class="px-6 py-4 border-t">

        {{ $logs->links() }}

    </div>

</div>

@endsection