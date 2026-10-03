@php
    $statuses = [
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
    ];

    $priorities = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent',
    ];
@endphp

<div class="row g-4">

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-1">Lead Information</h5>
                <p class="text-muted mb-0 small">
                    Basic information about the school opportunity.
                </p>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">
                            Lead Code <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="lead_code"
                            class="form-control @error('lead_code') is-invalid @enderror"
                            value="{{ old('lead_code', $lead->lead_code ?? '') }}"
                            placeholder="LEAD-001"
                            required
                        >

                        @error('lead_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">
                            School Name <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="school_name"
                            class="form-control @error('school_name') is-invalid @enderror"
                            value="{{ old('school_name', $lead->school_name ?? '') }}"
                            placeholder="Enter school name"
                            required
                        >

                        @error('school_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Contact Person
                        </label>

                        <input
                            type="text"
                            name="contact_person"
                            class="form-control @error('contact_person') is-invalid @enderror"
                            value="{{ old('contact_person', $lead->contact_person ?? '') }}"
                            placeholder="Principal / Director / Contact Person"
                        >

                        @error('contact_person')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            Phone
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $lead->phone ?? '') }}"
                            placeholder="Phone number"
                        >

                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $lead->email ?? '') }}"
                            placeholder="Email address"
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-1">Location & School Details</h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">
                            Address
                        </label>

                        <textarea
                            name="address"
                            rows="3"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="School address"
                        >{{ old('address', $lead->address ?? '') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            City
                        </label>

                        <input
                            type="text"
                            name="city"
                            class="form-control @error('city') is-invalid @enderror"
                            value="{{ old('city', $lead->city ?? '') }}"
                        >

                        @error('city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            State
                        </label>

                        <input
                            type="text"
                            name="state"
                            class="form-control @error('state') is-invalid @enderror"
                            value="{{ old('state', $lead->state ?? '') }}"
                        >

                        @error('state')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            Pincode
                        </label>

                        <input
                            type="text"
                            name="pincode"
                            class="form-control @error('pincode') is-invalid @enderror"
                            value="{{ old('pincode', $lead->pincode ?? '') }}"
                        >

                        @error('pincode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            School Type
                        </label>

                        <input
                            type="text"
                            name="school_type"
                            class="form-control @error('school_type') is-invalid @enderror"
                            value="{{ old('school_type', $lead->school_type ?? '') }}"
                            placeholder="CBSE / ICSE / Private..."
                        >

                        @error('school_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            Student Strength
                        </label>

                        <input
                            type="number"
                            name="estimated_student_strength"
                            min="0"
                            class="form-control @error('estimated_student_strength') is-invalid @enderror"
                            value="{{ old('estimated_student_strength', $lead->estimated_student_strength ?? '') }}"
                        >

                        @error('estimated_student_strength')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-1">Sales Information</h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">
                            Lead Source
                        </label>

                        <select
                            name="lead_source_id"
                            class="form-select @error('lead_source_id') is-invalid @enderror"
                        >
                            <option value="">Select source</option>

                            @foreach($leadSources as $source)
                                <option
                                    value="{{ $source->id }}"
                                    @selected(
                                        old(
                                            'lead_source_id',
                                            $lead->lead_source_id ?? ''
                                        ) == $source->id
                                    )
                                >
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('lead_source_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Required Program
                        </label>

                        <select
                            name="required_program_id"
                            class="form-select @error('required_program_id') is-invalid @enderror"
                        >
                            <option value="">Select program</option>

                            @foreach($programs as $program)
                                <option
                                    value="{{ $program->id }}"
                                    @selected(
                                        old(
                                            'required_program_id',
                                            $lead->required_program_id ?? ''
                                        ) == $program->id
                                    )
                                >
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('required_program_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Assigned Sales Employee
                        </label>

                        <select
                            name="assigned_sales_employee_id"
                            class="form-select @error('assigned_sales_employee_id') is-invalid @enderror"
                        >
                            <option value="">Unassigned</option>

                            @foreach($salesEmployees as $employee)
                                <option
                                    value="{{ $employee->id }}"
                                    @selected(
                                        old(
                                            'assigned_sales_employee_id',
                                            $lead->assigned_sales_employee_id ?? ''
                                        ) == $employee->id
                                    )
                                >
                                    {{ $employee->employee_code }}
                                    —
                                    {{ $employee->user?->name ?? $employee->designation ?? 'Employee' }}
                                </option>
                            @endforeach
                        </select>

                        @error('assigned_sales_employee_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>

                        <select
                            name="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required
                        >
                            @foreach($statuses as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(
                                        old(
                                            'status',
                                            $lead->status ?? 'new'
                                        ) === $value
                                    )
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Priority <span class="text-danger">*</span>
                        </label>

                        <select
                            name="priority"
                            class="form-select @error('priority') is-invalid @enderror"
                            required
                        >
                            @foreach($priorities as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(
                                        old(
                                            'priority',
                                            $lead->priority ?? 'medium'
                                        ) === $value
                                    )
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('priority')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Next Follow-up
                        </label>

                        <input
                            type="datetime-local"
                            name="next_followup_at"
                            class="form-control @error('next_followup_at') is-invalid @enderror"
                            value="{{ old(
                                'next_followup_at',
                                isset($lead->next_followup_at)
                                    ? $lead->next_followup_at->format('Y-m-d\TH:i')
                                    : ''
                            ) }}"
                        >

                        @error('next_followup_at')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            rows="4"
                            class="form-control @error('remarks') is-invalid @enderror"
                            placeholder="Additional sales notes..."
                        >{{ old('remarks', $lead->remarks ?? '') }}</textarea>

                        @error('remarks')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>