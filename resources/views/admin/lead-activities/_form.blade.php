@php
    $activityTypes = [
        'call' => 'Call',
        'school_visit' => 'School Visit',
        'meeting' => 'Meeting',
        'email' => 'Email',
        'whatsapp' => 'WhatsApp',
        'note' => 'Note',
        'other' => 'Other',
    ];
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Activity Type <span class="text-red-400">*</span>
        </label>

        <select
            name="activity_type"
            required
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100 focus:border-blue-500 focus:ring-blue-500"
        >
            <option value="">Select Activity Type</option>

            @foreach($activityTypes as $value => $label)
                <option
                    value="{{ $value }}"
                    @selected(old('activity_type', $activity->activity_type ?? '') === $value)
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('activity_type')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Sales Employee
        </label>

        <select
            name="sales_employee_id"
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100 focus:border-blue-500 focus:ring-blue-500"
        >
            <option value="">Select Sales Employee</option>

            @foreach($salesEmployees as $employee)
                <option
                    value="{{ $employee->id }}"
                    @selected((string) old('sales_employee_id', $activity->sales_employee_id ?? '') === (string) $employee->id)
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

    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Subject <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="subject"
            value="{{ old('subject', $activity->subject ?? '') }}"
            required
            maxlength="255"
            placeholder="Example: Discussed robotics lab requirements"
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
        >

        @error('subject')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-slate-300">
            Activity Date & Time <span class="text-red-400">*</span>
        </label>

        <input
            type="datetime-local"
            name="activity_at"
            value="{{ old('activity_at', isset($activity) && $activity->activity_at ? $activity->activity_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
            required
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100 focus:border-blue-500 focus:ring-blue-500"
        >

        @error('activity_at')
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
            value="{{ old('outcome', $activity->outcome ?? '') }}"
            placeholder="Example: Interested / Follow-up required"
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-100 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
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
            placeholder="Enter detailed activity notes..."
            class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
        >{{ old('notes', $activity->notes ?? '') }}</textarea>

        @error('notes')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-6 flex items-center justify-end gap-3">

    <a
        href="{{ route('admin.leads.activities.index', $lead) }}"
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