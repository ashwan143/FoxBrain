@extends('admin.layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Lead Activities
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
                    href="{{ route('admin.leads.activities.create', $lead) }}"
                    class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    + Add Activity
                </a>
            @endif

        </div>

    </div>

    {{-- Flash --}}
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

    {{-- Lead summary --}}
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
                Status
            </p>

            <p class="mt-2 font-semibold capitalize text-white">
                {{ str_replace('_', ' ', $lead->status) }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">
                Activities
            </p>

            <p class="mt-2 font-semibold text-white">
                {{ $activities->total() }}
            </p>
        </div>

    </div>

    {{-- Activities --}}
    <div class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900">

        <div class="border-b border-slate-800 px-5 py-4">
            <h2 class="font-semibold text-white">
                Activity History
            </h2>
        </div>

        @if($activities->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-800">

                    <thead class="bg-slate-950">

                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Date
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Type
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Subject
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Sales Employee
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

                        @foreach($activities as $activity)

                            <tr class="hover:bg-slate-800/40">

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-300">
                                    {{ $activity->activity_at?->format('d M Y') }}
                                    <div class="text-xs text-slate-500">
                                        {{ $activity->activity_at?->format('h:i A') }}
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">

                                    @php
                                        $typeLabels = [
                                            'call' => 'Call',
                                            'school_visit' => 'School Visit',
                                            'meeting' => 'Meeting',
                                            'email' => 'Email',
                                            'whatsapp' => 'WhatsApp',
                                            'note' => 'Note',
                                            'other' => 'Other',
                                        ];
                                    @endphp

                                    <span class="inline-flex rounded-full border border-blue-800 bg-blue-950/50 px-2.5 py-1 text-xs font-medium text-blue-300">
                                        {{ $typeLabels[$activity->activity_type] ?? ucfirst($activity->activity_type) }}
                                    </span>

                                </td>

                                <td class="max-w-xs px-5 py-4">

                                    <div class="font-medium text-white">
                                        {{ $activity->subject }}
                                    </div>

                                    @if($activity->notes)
                                        <div class="mt-1 line-clamp-2 text-xs text-slate-500">
                                            {{ $activity->notes }}
                                        </div>
                                    @endif

                                </td>

                                <td class="px-5 py-4 text-sm text-slate-300">

                                    @if($activity->salesEmployee?->user)
                                        {{ $activity->salesEmployee->user->name }}
                                    @elseif($activity->salesEmployee)
                                        {{ $activity->salesEmployee->employee_code }}
                                    @else
                                        —
                                    @endif

                                </td>

                                <td class="max-w-xs px-5 py-4 text-sm text-slate-400">
                                    {{ $activity->outcome ?: '—' }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right">

                                    <div class="flex justify-end gap-2">

                                        @if(auth()->user()->hasPermission('leads.edit'))

                                            <a
                                                href="{{ route('admin.leads.activities.edit', [$lead, $activity]) }}"
                                                class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-xs font-medium text-slate-200 hover:bg-slate-700"
                                            >
                                                Edit
                                            </a>

                                        @endif

                                        @if(auth()->user()->hasPermission('leads.delete'))

                                            <form
                                                method="POST"
                                                action="{{ route('admin.leads.activities.destroy', [$lead, $activity]) }}"
                                                onsubmit="return confirm('Delete this activity?');"
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

            @if($activities->hasPages())
                <div class="border-t border-slate-800 px-5 py-4">
                    {{ $activities->links() }}
                </div>
            @endif

        @else

            <div class="px-5 py-16 text-center">

                <div class="text-lg font-semibold text-white">
                    No activities found
                </div>

                <p class="mt-2 text-sm text-slate-500">
                    Start recording calls, meetings, visits and other interactions with this lead.
                </p>

                @if(auth()->user()->hasPermission('leads.create'))

                    <a
                        href="{{ route('admin.leads.activities.create', $lead) }}"
                        class="mt-5 inline-flex rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        + Add First Activity
                    </a>

                @endif

            </div>

        @endif

    </div>

</div>

@endsection