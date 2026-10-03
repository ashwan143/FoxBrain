@extends('admin.layouts.app')

@section('title', 'Lead Details')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="text-muted small mb-1">
                Lead {{ $lead->lead_code }}
            </div>

            <h1 class="h3 mb-1">
                {{ $lead->school_name }}
            </h1>

            <p class="text-muted mb-0">
                School sales opportunity details and activity.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.leads.index') }}"
                class="btn btn-outline-secondary"
            >
                Back
            </a>

            @if(auth()->user()->hasPermission('leads.edit'))

                <a
                    href="{{ route('admin.leads.edit', $lead) }}"
                    class="btn btn-primary"
                >
                    Edit Lead
                </a>

            @endif

        </div>

    </div>


    {{-- SUMMARY --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-3">

                    <div class="text-muted small">
                        Status
                    </div>

                    <div class="fw-semibold mt-1">
                        {{ ucwords(str_replace('_', ' ', $lead->status)) }}
                    </div>

                </div>

                <div class="col-md-3">

                    <div class="text-muted small">
                        Priority
                    </div>

                    <div class="fw-semibold mt-1">
                        {{ ucfirst($lead->priority) }}
                    </div>

                </div>

                <div class="col-md-3">

                    <div class="text-muted small">
                        Assigned Sales Employee
                    </div>

                    <div class="fw-semibold mt-1">

                        @if($lead->assignedSalesEmployee)

                            {{ $lead->assignedSalesEmployee->user?->name
                                ?? $lead->assignedSalesEmployee->employee_code }}

                        @else

                            Unassigned

                        @endif

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="text-muted small">
                        Next Follow-up
                    </div>

                    <div class="fw-semibold mt-1">

                        @if($lead->next_followup_at)

                            {{ $lead->next_followup_at->format('d M Y, h:i A') }}

                        @else

                            Not scheduled

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="row g-4">

        {{-- BASIC DETAILS --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        Lead Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Contact Person
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->contact_person ?: '—' }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Phone
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->phone ?: '—' }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Email
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->email ?: '—' }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Lead Source
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->leadSource?->name ?? '—' }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Required Program
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->requiredProgram?->name ?? '—' }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">
                                School Type
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->school_type ?: '—' }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Estimated Student Strength
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->estimated_student_strength !== null
                                    ? number_format($lead->estimated_student_strength)
                                    : '—' }}
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Created By
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->creator?->name ?? '—' }}
                            </div>

                        </div>

                        <div class="col-12">

                            <div class="text-muted small">
                                Address
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->address ?: '—' }}
                            </div>

                            @if($lead->city || $lead->state || $lead->pincode)

                                <div class="text-muted mt-1">

                                    {{ $lead->city }}

                                    @if($lead->city && $lead->state)
                                        ,
                                    @endif

                                    {{ $lead->state }}

                                    @if($lead->pincode)
                                        - {{ $lead->pincode }}
                                    @endif

                                </div>

                            @endif

                        </div>

                        <div class="col-12">

                            <div class="text-muted small">
                                Remarks
                            </div>

                            <div class="fw-semibold">
                                {{ $lead->remarks ?: 'No remarks added.' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ACTIVITY --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        Lead Activities
                    </h5>

                </div>

                <div class="card-body">

                    @forelse($lead->activities as $activity)

                        <div class="border-bottom pb-3 mb-3">

                            <div class="d-flex justify-content-between">

                                <div class="fw-semibold">
                                    {{ ucwords(str_replace('_', ' ', $activity->activity_type)) }}
                                </div>

                                <div class="text-muted small">
                                    {{ $activity->activity_at?->format('d M Y, h:i A') }}
                                </div>

                            </div>

                            @if($activity->subject)

                                <div class="mt-1">
                                    {{ $activity->subject }}
                                </div>

                            @endif

                            @if($activity->notes)

                                <div class="text-muted mt-1">
                                    {{ $activity->notes }}
                                </div>

                            @endif

                            @if($activity->outcome)

                                <div class="small mt-1">
                                    <strong>Outcome:</strong>
                                    {{ $activity->outcome }}
                                </div>

                            @endif

                        </div>

                    @empty

                        <div class="text-muted">
                            No activities recorded yet.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- SIDE --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        Sales Pipeline
                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <div class="text-muted small">
                            Lead Code
                        </div>

                        <div class="fw-semibold">
                            {{ $lead->lead_code }}
                        </div>

                    </div>

                    <div class="mb-3">

                        <div class="text-muted small">
                            Source
                        </div>

                        <div class="fw-semibold">
                            {{ $lead->leadSource?->name ?? '—' }}
                        </div>

                    </div>

                    <div class="mb-3">

                        <div class="text-muted small">
                            Program
                        </div>

                        <div class="fw-semibold">
                            {{ $lead->requiredProgram?->name ?? '—' }}
                        </div>

                    </div>

                    <div>

                        <div class="text-muted small">
                            Created
                        </div>

                        <div class="fw-semibold">
                            {{ $lead->created_at?->format('d M Y, h:i A') }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0">
                        Follow-ups
                    </h5>

                </div>

                <div class="card-body">

                    @forelse($lead->followups as $followup)

                        <div class="border-bottom pb-3 mb-3">

                            <div class="fw-semibold">
                                {{ ucfirst($followup->status) }}
                            </div>

                            <div class="text-muted small">
                                {{ $followup->scheduled_at?->format('d M Y, h:i A') }}
                            </div>

                            @if($followup->notes)

                                <div class="mt-1 small">
                                    {{ $followup->notes }}
                                </div>

                            @endif

                        </div>

                    @empty

                        <div class="text-muted">
                            No follow-ups recorded yet.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection