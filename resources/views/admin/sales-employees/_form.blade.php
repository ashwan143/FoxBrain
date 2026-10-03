<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- User Account --}}
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            User Account
        </label>

        <select
            name="user_id"
            class="w-full rounded-lg border border-slate-700 bg-slate-900
                   px-4 py-3 text-slate-100 focus:border-blue-500
                   focus:ring-blue-500"
        >
            <option value="">No linked user</option>

            @foreach($users as $user)
                <option
                    value="{{ $user->id }}"
                    @selected(old('user_id', $salesEmployee->user_id ?? '') == $user->id)
                >
                    {{ $user->name }} — {{ $user->email }}
                </option>
            @endforeach
        </select>

        @error('user_id')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Employee Code --}}
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Employee Code *
        </label>

        <input
            type="text"
            name="employee_code"
            value="{{ old('employee_code', $salesEmployee->employee_code ?? '') }}"
            required
            class="w-full rounded-lg border border-slate-700 bg-slate-900
                   px-4 py-3 text-slate-100 focus:border-blue-500
                   focus:ring-blue-500"
            placeholder="SE-001"
        >

        @error('employee_code')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Manager --}}
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Reporting Manager
        </label>

        <select
            name="manager_id"
            class="w-full rounded-lg border border-slate-700 bg-slate-900
                   px-4 py-3 text-slate-100 focus:border-blue-500
                   focus:ring-blue-500"
        >
            <option value="">No Manager</option>

            @foreach($managers as $manager)
                <option
                    value="{{ $manager->id }}"
                    @selected(old('manager_id', $salesEmployee->manager_id ?? '') == $manager->id)
                >
                    {{ $manager->employee_code }}
                    @if($manager->user)
                        — {{ $manager->user->name }}
                    @endif
                </option>
            @endforeach
        </select>

        @error('manager_id')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Designation --}}
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Designation
        </label>

        <input
            type="text"
            name="designation"
            value="{{ old('designation', $salesEmployee->designation ?? '') }}"
            class="w-full rounded-lg border border-slate-700 bg-slate-900
                   px-4 py-3 text-slate-100 focus:border-blue-500
                   focus:ring-blue-500"
            placeholder="Sales Executive"
        >

        @error('designation')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Joining Date --}}
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Joining Date
        </label>

        <input
            type="date"
            name="joining_date"
            value="{{ old(
                'joining_date',
                isset($salesEmployee) && $salesEmployee->joining_date
                    ? $salesEmployee->joining_date->format('Y-m-d')
                    : ''
            ) }}"
            class="w-full rounded-lg border border-slate-700 bg-slate-900
                   px-4 py-3 text-slate-100 focus:border-blue-500
                   focus:ring-blue-500"
        >

        @error('joining_date')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Phone --}}
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Phone
        </label>

        <input
            type="text"
            name="phone"
            value="{{ old('phone', $salesEmployee->phone ?? '') }}"
            class="w-full rounded-lg border border-slate-700 bg-slate-900
                   px-4 py-3 text-slate-100 focus:border-blue-500
                   focus:ring-blue-500"
            placeholder="+91..."
        >

        @error('phone')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Status *
        </label>

        <select
            name="status"
            required
            class="w-full rounded-lg border border-slate-700 bg-slate-900
                   px-4 py-3 text-slate-100 focus:border-blue-500
                   focus:ring-blue-500"
        >
            @foreach([
                'active' => 'Active',
                'inactive' => 'Inactive',
                'on_leave' => 'On Leave',
            ] as $value => $label)

                <option
                    value="{{ $value }}"
                    @selected(old('status', $salesEmployee->status ?? 'active') === $value)
                >
                    {{ $label }}
                </option>

            @endforeach
        </select>

        @error('status')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Notes --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Notes
        </label>

        <textarea
            name="notes"
            rows="5"
            class="w-full rounded-lg border border-slate-700 bg-slate-900
                   px-4 py-3 text-slate-100 focus:border-blue-500
                   focus:ring-blue-500"
            placeholder="Internal notes..."
        >{{ old('notes', $salesEmployee->notes ?? '') }}</textarea>

        @error('notes')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-6 flex justify-end gap-3">

    <a
        href="{{ route('admin.sales-employees.index') }}"
        class="rounded-lg bg-slate-800 px-5 py-3 text-sm font-medium
               text-slate-200 hover:bg-slate-700"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-medium
               text-white hover:bg-blue-500"
    >
        {{ isset($salesEmployee) ? 'Update Employee' : 'Create Employee' }}
    </button>

</div>