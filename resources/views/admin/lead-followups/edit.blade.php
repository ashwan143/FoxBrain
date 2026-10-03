@extends('admin.layouts.app')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Edit Lead Follow-up
            </h1>

            <p class="mt-1 text-sm text-slate-400">
                {{ $lead->lead_code }} —
                {{ $lead->school_name }}
            </p>
        </div>

        <a
            href="{{ route('admin.leads.followups.index', $lead) }}"
            class="rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-medium text-slate-200 hover:bg-slate-700"
        >
            Back to Follow-ups
        </a>

    </div>

    <div class="rounded-xl border border-slate-800 bg-slate-900 p-6">

        <form
            method="POST"
            action="{{ route('admin.leads.followups.update', [$lead, $followup]) }}"
        >
            @csrf
            @method('PUT')

            @php
                $buttonText = 'Update Follow-up';
            @endphp

            @include('admin.lead-followups._form')

        </form>

    </div>

</div>

@endsection