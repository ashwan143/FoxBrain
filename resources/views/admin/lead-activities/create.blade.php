@extends('admin.layouts.app')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Add Lead Activity
            </h1>

            <p class="mt-1 text-sm text-slate-400">
                {{ $lead->lead_code }} —
                {{ $lead->school_name }}
            </p>
        </div>

        <a
            href="{{ route('admin.leads.show', $lead) }}"
            class="inline-flex items-center justify-center rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-medium text-slate-200 hover:bg-slate-700"
        >
            Back to Lead
        </a>

    </div>

    @if($errors->any())
        <div class="rounded-xl border border-red-900 bg-red-950/50 p-4">
            <p class="font-semibold text-red-300">
                Please correct the following errors:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-400">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-xl border border-slate-800 bg-slate-900 p-6">

        <form
            method="POST"
            action="{{ route('admin.leads.activities.store', $lead) }}"
        >
            @csrf

            @php
                $activity = null;
                $buttonText = 'Create Activity';
            @endphp

            @include('admin.lead-activities._form')

        </form>

    </div>

</div>

@endsection