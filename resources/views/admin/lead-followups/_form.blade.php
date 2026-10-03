@php
    $followupTypes = [
        'call' => 'Call',
        'visit' => 'Visit',
        'meeting' => 'Meeting',
        'email' => 'Email',
        'whatsapp' => 'WhatsApp',
        'other' => 'Other',
    ];

    $statuses = [
        'scheduled' => 'Scheduled',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'missed' => 'Missed',
    ];
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Follow-up Type <span class="text-red-400">*</span>
        </label>

        <select
            name="followup_type"
            required
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100"
        >
            <option value="">Select Type</option>

            @foreach($followupTypes as $value => $label)
                <option
                    value="{{ $value }}"
                    @selected(old('followup_type', $followup->followup_type ?? '') === $value)
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('followup_type')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Status <span class="text-red-400">*</span>
        </label>

        <select
            name="status"
            required
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100"
        >
            @foreach($statuses as $value => $label)
                <option
                    value="{{ $value }}"
                    @selected(old('status', $followup->status ?? 'scheduled') === $value)
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('status')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Sales Employee
        </label>

        <select
            name="sales_employee_id"
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100"
        >
            <option value="">Select Sales Employee</option>

            @foreach($salesEmployees as $employee)
                <option
                    value="{{ $employee->id }}"
                    @selected((string) old('sales_employee_id', $followup->sales_employee_id ?? '') === (string) $employee->id)
                >
                    {{ $employee->employee_code }}
                    @if($employee->user)
                        — {{ $employee->user->name }}
                    @endif
                </option>
            @endforeach
        </select>

        @error('sales_employee_id')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Scheduled At <span class="text-red-400">*</span>
        </label>

        <input
            type="datetime-local"
            name="scheduled_at"
            required
            value="{{ old('scheduled_at', isset($followup) && $followup->scheduled_at ? $followup->scheduled_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100"
        >

        @error('scheduled_at')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Completed At
        </label>

        <input
            type="datetime-local"
            name="completed_at"
            value="{{ old('completed_at', isset($followup) && $followup->completed_at ? $followup->completed_at->format('Y-m-d\TH:i') : '') }}"
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100"
        >

        @error('completed_at')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Outcome
        </label>

        <input
            type="text"
            name="outcome"
            value="{{ old('outcome', $followup->outcome ?? '') }}"
            placeholder="Example: Proposal requested"
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100 placeholder-slate-500"
        >

        @error('outcome')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">

        <label class="mb-2 block text-sm font-medium text-slate-300">
            Notes
        </label>

        <textarea
            name="notes"
            rows="6"
            placeholder="Enter follow-up notes..."
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 placeholder-slate-500"
        >{{ old('notes', $followup->notes ?? '') }}</textarea>

        @error('notes')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror

    </div>

</div>

<div class="mt-6 flex justify-end gap-3">

    <a
        href="{{ route('admin.leads.followups.index', $lead) }}"
        class="rounded-lg border border-slate-700 bg-slate-800 px-5 py-2.5 text-sm font-medium text-slate-200 hover:bg-slate-700"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
    >
        {{ $buttonText }}
    </button>

</div>