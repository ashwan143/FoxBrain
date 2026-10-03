@extends('admin.layouts.app')

@section('title', 'Leads')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold text-white">
                Leads
            </h1>

            <p class="mt-1 text-sm text-slate-400">
                Manage school prospects, sales opportunities and follow-ups.
            </p>

        </div>

        @if(auth()->user()->hasPermission('leads.create'))

            <a
                href="{{ route('admin.leads.create') }}"
                class="inline-flex items-center justify-center rounded-lg
                       bg-blue-600 px-5 py-3 text-sm font-semibold text-white
                       hover:bg-blue-500"
            >
                + Add Lead
            </a>

        @endif

    </div>


    {{-- Flash Messages --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-800 bg-green-950/50
                    px-4 py-3 text-sm text-green-300">

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="rounded-lg border border-red-800 bg-red-950/50
                    px-4 py-3 text-sm text-red-300">

            {{ session('error') }}

        </div>

    @endif


    {{-- Statistics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Total --}}
        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-400">
                        Total Leads
                    </p>

                    <p class="mt-2 text-2xl font-bold text-white">
                        {{ $stats['total'] ?? 0 }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-lg bg-blue-950 text-blue-400"
                >
                    +
                </div>

            </div>

        </div>


        {{-- New --}}
        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-400">
                        New Leads
                    </p>

                    <p class="mt-2 text-2xl font-bold text-white">
                        {{ $stats['new'] ?? 0 }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-lg bg-purple-950 text-purple-400"
                >
                    N
                </div>

            </div>

        </div>


        {{-- Qualified --}}
        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-400">
                        Qualified
                    </p>

                    <p class="mt-2 text-2xl font-bold text-white">
                        {{ $stats['qualified'] ?? 0 }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-lg bg-green-950 text-green-400"
                >
                    Q
                </div>

            </div>

        </div>


        {{-- Won --}}
        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-400">
                        Won
                    </p>

                    <p class="mt-2 text-2xl font-bold text-white">
                        {{ $stats['won'] ?? 0 }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-lg bg-yellow-950 text-yellow-400"
                >
                    W
                </div>

            </div>

        </div>

    </div>


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">

        <form
            method="GET"
            action="{{ route('admin.leads.index') }}"
            class="grid grid-cols-1 gap-4 lg:grid-cols-6"
        >

            {{-- Search --}}
            <div class="lg:col-span-2">

                <label class="mb-2 block text-sm text-slate-400">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Lead code, school, contact, phone..."
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-950 px-4 py-3 text-slate-100
                           placeholder-slate-500
                           focus:border-blue-500 focus:ring-blue-500"
                >

            </div>


            {{-- Status --}}
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

                    <option value="">
                        All Statuses
                    </option>

                    @foreach([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'qualified' => 'Qualified',
                        'requirement_collected' => 'Requirement Collected',
                        'proposal_sent' => 'Proposal Sent',
                        'negotiation' => 'Negotiation',
                        'won' => 'Won',
                        'lost' => 'Lost',
                        'on_hold' => 'On Hold',
                        'not_interested' => 'Not Interested',
                        'future_opportunity' => 'Future Opportunity',
                    ] as $value => $label)

                        <option
                            value="{{ $value }}"
                            @selected(request('status') === $value)
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Priority --}}
            <div>

                <label class="mb-2 block text-sm text-slate-400">
                    Priority
                </label>

                <select
                    name="priority"
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-950 px-4 py-3 text-slate-100
                           focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        All Priorities
                    </option>

                    <option value="low"
                        @selected(request('priority') === 'low')>
                        Low
                    </option>

                    <option value="medium"
                        @selected(request('priority') === 'medium')>
                        Medium
                    </option>

                    <option value="high"
                        @selected(request('priority') === 'high')>
                        High
                    </option>

                    <option value="urgent"
                        @selected(request('priority') === 'urgent')>
                        Urgent
                    </option>

                </select>

            </div>


            {{-- Sales Employee --}}
            <div>

                <label class="mb-2 block text-sm text-slate-400">
                    Sales Employee
                </label>

                <select
                    name="assigned_sales_employee_id"
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-950 px-4 py-3 text-slate-100
                           focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        All Employees
                    </option>

                    @foreach($salesEmployees as $employee)

                        <option
                            value="{{ $employee->id }}"
                            @selected(
                                request('assigned_sales_employee_id') == $employee->id
                            )
                        >
                            {{ $employee->user?->name
                                ?? $employee->employee_code }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Buttons --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="rounded-lg bg-slate-700 px-5 py-3 text-sm
                           font-medium text-white hover:bg-slate-600"
                >
                    Filter
                </button>

                <a
                    href="{{ route('admin.leads.index') }}"
                    class="rounded-lg bg-slate-800 px-5 py-3 text-sm
                           font-medium text-slate-300 hover:bg-slate-700"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Leads Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-800">

                <thead class="bg-slate-950">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Lead
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Contact
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Program
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Sales Employee
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Priority
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Follow-up
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-400">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-800">

                    @forelse($leads as $lead)

                        <tr class="hover:bg-slate-800/40">

                            {{-- Lead --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-10 w-10 shrink-0
                                               items-center justify-center rounded-lg
                                               bg-blue-950 text-sm font-bold
                                               text-blue-400"
                                    >
                                        {{ strtoupper(substr($lead->school_name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <a
                                            href="{{ route(
                                                'admin.leads.show',
                                                $lead
                                            ) }}"
                                            class="font-medium text-white
                                                   hover:text-blue-400"
                                        >
                                            {{ $lead->school_name }}
                                        </a>

                                        <div class="text-xs text-slate-500">
                                            {{ $lead->lead_code }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Contact --}}
                            <td class="px-6 py-4">

                                <div class="text-sm text-slate-300">
                                    {{ $lead->contact_person ?: '—' }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $lead->phone ?: ($lead->email ?: '—') }}
                                </div>

                            </td>


                            {{-- Program --}}
                            <td class="px-6 py-4 text-sm text-slate-300">

                                {{ $lead->requiredProgram?->name ?? '—' }}

                            </td>


                            {{-- Employee --}}
                            <td class="px-6 py-4">

                                @if($lead->assignedSalesEmployee)

                                    <div class="text-sm text-slate-300">

                                        {{ $lead->assignedSalesEmployee->user?->name
                                            ?? $lead->assignedSalesEmployee->employee_code }}

                                    </div>

                                    <div class="text-xs text-slate-500">

                                        {{ $lead->assignedSalesEmployee->employee_code }}

                                    </div>

                                @else

                                    <span class="text-sm text-slate-500">
                                        Unassigned
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @php

                                    $statusClasses = [
                                        'new' =>
                                            'bg-blue-950 text-blue-300 border-blue-800',

                                        'contacted' =>
                                            'bg-cyan-950 text-cyan-300 border-cyan-800',

                                        'qualified' =>
                                            'bg-green-950 text-green-300 border-green-800',

                                        'requirement_collected' =>
                                            'bg-purple-950 text-purple-300 border-purple-800',

                                        'proposal_sent' =>
                                            'bg-indigo-950 text-indigo-300 border-indigo-800',

                                        'negotiation' =>
                                            'bg-yellow-950 text-yellow-300 border-yellow-800',

                                        'won' =>
                                            'bg-emerald-950 text-emerald-300 border-emerald-800',

                                        'lost' =>
                                            'bg-red-950 text-red-300 border-red-800',

                                        'on_hold' =>
                                            'bg-slate-800 text-slate-300 border-slate-700',

                                        'not_interested' =>
                                            'bg-red-950 text-red-300 border-red-800',

                                        'future_opportunity' =>
                                            'bg-orange-950 text-orange-300 border-orange-800',
                                    ];

                                @endphp

                                <span
                                    class="inline-flex rounded-full border px-3 py-1
                                           text-xs font-medium
                                           {{ $statusClasses[$lead->status] ?? 'bg-slate-800 text-slate-300 border-slate-700' }}"
                                >

                                    {{ str_replace(
                                        '_',
                                        ' ',
                                        ucfirst($lead->status)
                                    ) }}

                                </span>

                            </td>


                            {{-- Priority --}}
                            <td class="px-6 py-4">

                                @php

                                    $priorityClasses = [
                                        'low' =>
                                            'bg-slate-800 text-slate-300 border-slate-700',

                                        'medium' =>
                                            'bg-yellow-950 text-yellow-300 border-yellow-800',

                                        'high' =>
                                            'bg-orange-950 text-orange-300 border-orange-800',

                                        'urgent' =>
                                            'bg-red-950 text-red-300 border-red-800',
                                    ];

                                @endphp

                                <span
                                    class="inline-flex rounded-full border px-3 py-1
                                           text-xs font-medium
                                           {{ $priorityClasses[$lead->priority] ?? '' }}"
                                >

                                    {{ ucfirst($lead->priority) }}

                                </span>

                            </td>


                            {{-- Follow-up --}}
                            <td class="px-6 py-4">

                                @if($lead->next_followup_at)

                                    <div class="text-sm text-slate-300">

                                        {{ $lead->next_followup_at->format('d M Y') }}

                                    </div>

                                    <div class="text-xs text-slate-500">

                                        {{ $lead->next_followup_at->format('h:i A') }}

                                    </div>

                                @else

                                    <span class="text-sm text-slate-500">
                                        No follow-up
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route(
                                            'admin.leads.show',
                                            $lead
                                        ) }}"
                                        class="rounded-lg bg-slate-800 px-3 py-2
                                               text-sm text-slate-300
                                               hover:bg-slate-700"
                                    >
                                        View
                                    </a>


                                    @if(auth()->user()->hasPermission('leads.edit'))

                                        <a
                                            href="{{ route(
                                                'admin.leads.edit',
                                                $lead
                                            ) }}"
                                            class="rounded-lg bg-blue-950 px-3 py-2
                                                   text-sm text-blue-300
                                                   hover:bg-blue-900"
                                        >
                                            Edit
                                        </a>

                                    @endif


                                    @if(auth()->user()->hasPermission('leads.delete'))

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.leads.destroy',
                                                $lead
                                            ) }}"
                                            onsubmit="return confirm(
                                                'Delete this lead?'
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
                                colspan="8"
                                class="px-6 py-12 text-center text-slate-500"
                            >

                                No leads found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($leads->hasPages())

            <div class="border-t border-slate-800 px-6 py-4">

                {{ $leads->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection