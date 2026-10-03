@extends('admin.layouts.app')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Lead Follow-ups
            </h1>

            <p class="mt-1 text-sm text-slate-400">
                {{ $lead->lead_code }} —
                {{ $lead->school_name }}
            </p>
        </div>

        <div class="flex gap-3">

            <a
                href="{{ route('admin.leads.show', $lead) }}"
                class="rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-medium text-slate-200 hover:bg-slate-700"
            >
                View Lead
            </a>

            @if(auth()->user()->hasPermission('leads.create'))
                <a
                    href="{{ route('admin.leads.followups.create', $lead) }}"
                    class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    + Schedule Follow-up
                </a>
            @endif

        </div>

    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-900 bg-green-950/50 p-4 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-900 bg-red-950/50 p-4 text-sm text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">
                Lead Code
            </p>

            <p class="mt-2 font-semibold text-white">
                {{ $lead->lead_code }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">
                School
            </p>

            <p class="mt-2 font-semibold text-white">
                {{ $lead->school_name }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">
                Lead Status
            </p>

            <p class="mt-2 font-semibold capitalize text-white">
                {{ str_replace('_', ' ', $lead->status) }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">
                Follow-ups
            </p>

            <p class="mt-2 font-semibold text-white">
                {{ $followups->total() }}
            </p>
        </div>

    </div>

    <div class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900">

        <div class="border-b border-slate-800 px-5 py-4">
            <h2 class="font-semibold text-white">
                Follow-up Schedule
            </h2>
        </div>

        @if($followups->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-800">

                    <thead class="bg-slate-950">

                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Scheduled
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Type
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Sales Employee
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Status
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Outcome
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Actions
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-800">

                        @foreach($followups as $followup)

                            <tr class="hover:bg-slate-800/40">

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-300">
                                    {{ $followup->scheduled_at?->format('d M Y') }}

                                    <div class="text-xs text-slate-500">
                                        {{ $followup->scheduled_at?->format('h:i A') }}
                                    </div>
                                </td>

                                <td class="px-5 py-4">

                                    @php
                                        $typeLabels = [
                                            'call' => 'Call',
                                            'visit' => 'Visit',
                                            'meeting' => 'Meeting',
                                            'email' => 'Email',
                                            'whatsapp' => 'WhatsApp',
                                            'other' => 'Other',
                                        ];
                                    @endphp

                                    <span class="inline-flex rounded-full border border-blue-800 bg-blue-950/50 px-2.5 py-1 text-xs font-medium text-blue-300">
                                        {{ $typeLabels[$followup->followup_type] ?? ucfirst($followup->followup_type) }}
                                    </span>

                                </td>

                                <td class="px-5 py-4 text-sm text-slate-300">
                                    @if($followup->salesEmployee?->user)
                                        {{ $followup->salesEmployee->user->name }}
                                    @elseif($followup->salesEmployee)
                                        {{ $followup->salesEmployee->employee_code }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="px-5 py-4">

                                    @php
                                        $statusClasses = [
                                            'scheduled' => 'border-yellow-800 bg-yellow-950/50 text-yellow-300',
                                            'completed' => 'border-green-800 bg-green-950/50 text-green-300',
                                            'cancelled' => 'border-red-800 bg-red-950/50 text-red-300',
                                            'missed' => 'border-orange-800 bg-orange-950/50 text-orange-300',
                                        ];
                                    @endphp

                                    <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-medium {{ $statusClasses[$followup->status] ?? 'border-slate-700 bg-slate-800 text-slate-300' }}">
                                        {{ ucfirst($followup->status) }}
                                    </span>

                                </td>

                                <td class="max-w-xs px-5 py-4 text-sm text-slate-400">
                                    {{ $followup->outcome ?: '—' }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right">

                                    <div class="flex justify-end gap-2">

                                        @if(auth()->user()->hasPermission('leads.edit'))

                                            <a
                                                href="{{ route('admin.leads.followups.edit', [$lead, $followup]) }}"
                                                class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-xs font-medium text-slate-200 hover:bg-slate-700"
                                            >
                                                Edit
                                            </a>

                                        @endif

                                        @if(auth()->user()->hasPermission('leads.delete'))

                                            <form
                                                method="POST"
                                                action="{{ route('admin.leads.followups.destroy', [$lead, $followup]) }}"
                                                onsubmit="return confirm('Delete this follow-up?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg border border-red-900 bg-red-950/50 px-3 py-2 text-xs font-medium text-red-300 hover:bg-red-900/60"
                                                >
                                                    Delete
                                                </button>
                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @if($followups->hasPages())
                <div class="border-t border-slate-800 px-5 py-4">
                    {{ $followups->links() }}
                </div>
            @endif

        @else

            <div class="px-5 py-16 text-center">

                <div class="text-lg font-semibold text-white">
                    No follow-ups scheduled
                </div>

                <p class="mt-2 text-sm text-slate-500">
                    Schedule the next call, visit, meeting or communication for this lead.
                </p>

                @if(auth()->user()->hasPermission('leads.create'))

                    <a
                        href="{{ route('admin.leads.followups.create', $lead) }}"
                        class="mt-5 inline-flex rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        + Schedule First Follow-up
                    </a>

                @endif

            </div>

        @endif

    </div>

</div>

@endsection