@extends('admin.layouts.app')

@section('title', 'Sales Employees')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Sales Employees
            </h1>

            <p class="mt-1 text-sm text-slate-400">
                Manage the FoxBrain sales team and reporting structure.
            </p>
        </div>

        @if(auth()->user()->hasPermission('sales_employees.create'))

            <a
                href="{{ route('admin.sales-employees.create') }}"
                class="inline-flex items-center justify-center rounded-lg
                       bg-blue-600 px-5 py-3 text-sm font-semibold text-white
                       hover:bg-blue-500"
            >
                + Add Sales Employee
            </a>

        @endif

    </div>

    {{-- Flash Message --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-800 bg-green-950/50
                    px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>

    @endif

    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-lg border border-red-800 bg-red-950/50
                    px-4 py-3 text-sm text-red-300">

            <ul class="list-disc pl-5 space-y-1">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    {{-- Filters --}}
    <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">

        <form
            method="GET"
            action="{{ route('admin.sales-employees.index') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-4"
        >

            <div class="md:col-span-2">

                <label class="mb-2 block text-sm text-slate-400">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Employee code, name, email, designation..."
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-950 px-4 py-3 text-slate-100
                           placeholder-slate-500 focus:border-blue-500
                           focus:ring-blue-500"
                >

            </div>

            <div>

                <label class="mb-2 block text-sm text-slate-400">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-950 px-4 py-3 text-slate-100
                           focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">All Statuses</option>

                    <option
                        value="active"
                        @selected($status === 'active')
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        @selected($status === 'inactive')
                    >
                        Inactive
                    </option>

                    <option
                        value="on_leave"
                        @selected($status === 'on_leave')
                    >
                        On Leave
                    </option>

                </select>

            </div>

            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="rounded-lg bg-slate-700 px-5 py-3 text-sm
                           font-medium text-white hover:bg-slate-600"
                >
                    Filter
                </button>

                <a
                    href="{{ route('admin.sales-employees.index') }}"
                    class="rounded-lg bg-slate-800 px-5 py-3 text-sm
                           font-medium text-slate-300 hover:bg-slate-700"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-800">

                <thead class="bg-slate-950">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Employee
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Designation
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Manager
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Leads
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-800">

                    @forelse($employees as $employee)

                        <tr class="hover:bg-slate-800/40">

                            <td class="px-6 py-4">

                                <div class="font-medium text-white">
                                    {{ $employee->user?->name ?? 'No User Linked' }}
                                </div>

                                <div class="text-sm text-slate-500">
                                    {{ $employee->employee_code }}
                                </div>

                                @if($employee->user?->email)

                                    <div class="text-xs text-slate-600">
                                        {{ $employee->user->email }}
                                    </div>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-sm text-slate-300">
                                {{ $employee->designation ?: '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-300">

                                @if($employee->manager)

                                    {{ $employee->manager->user?->name
                                        ?? $employee->manager->employee_code }}

                                @else
                                    —
                                @endif

                            </td>

                            <td class="px-6 py-4 text-sm text-slate-300">
                                {{ $employee->leads_count }}
                            </td>

                            <td class="px-6 py-4">

                                @php
                                    $statusClasses = [
                                        'active' =>
                                            'bg-green-950 text-green-300 border-green-800',

                                        'inactive' =>
                                            'bg-slate-800 text-slate-300 border-slate-700',

                                        'on_leave' =>
                                            'bg-yellow-950 text-yellow-300 border-yellow-800',
                                    ];
                                @endphp

                                <span
                                    class="inline-flex rounded-full border px-3 py-1
                                           text-xs font-medium
                                           {{ $statusClasses[$employee->status] ?? '' }}"
                                >
                                    {{ str_replace(
                                        '_',
                                        ' ',
                                        ucfirst($employee->status)
                                    ) }}
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    @if(auth()->user()->hasPermission('sales_employees.edit'))

                                        <a
                                            href="{{ route(
                                                'admin.sales-employees.edit',
                                                $employee
                                            ) }}"
                                            class="rounded-lg bg-slate-800 px-3 py-2
                                                   text-sm text-slate-300
                                                   hover:bg-slate-700"
                                        >
                                            Edit
                                        </a>

                                    @endif

                                    @if(auth()->user()->hasPermission('sales_employees.delete'))

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.sales-employees.destroy',
                                                $employee
                                            ) }}"
                                            onsubmit="return confirm(
                                                'Delete this sales employee?'
                                            );"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-950 px-3 py-2
                                                       text-sm text-red-300
                                                       hover:bg-red-900"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center text-slate-500"
                            >
                                No sales employees found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($employees->hasPages())

            <div class="border-t border-slate-800 px-6 py-4">
                {{ $employees->links() }}
            </div>

        @endif

    </div>

</div>

@endsection