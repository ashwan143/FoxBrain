<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Program Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $program->name ?? '') }}"
            required
            class="w-full rounded-lg bg-slate-900 border border-slate-700
                   text-white px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
        >

        @error('name')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Program Code
        </label>

        <input
            type="text"
            name="code"
            value="{{ old('code', $program->code ?? '') }}"
            class="w-full rounded-lg bg-slate-900 border border-slate-700
                   text-white px-4 py-3 uppercase"
        >

        @error('code')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Duration (Months)
        </label>

        <input
            type="number"
            name="duration_months"
            min="1"
            value="{{ old('duration_months', $program->duration_months ?? '') }}"
            class="w-full rounded-lg bg-slate-900 border border-slate-700
                   text-white px-4 py-3"
        >

        @error('duration_months')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Default Fee (₹)
        </label>

        <input
            type="number"
            name="default_fee"
            min="0"
            step="0.01"
            value="{{ old('default_fee', $program->default_fee ?? '0.00') }}"
            required
            class="w-full rounded-lg bg-slate-900 border border-slate-700
                   text-white px-4 py-3"
        >

        @error('default_fee')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">
            Status
        </label>

        <select
            name="status"
            required
            class="w-full rounded-lg bg-slate-900 border border-slate-700
                   text-white px-4 py-3"
        >
            <option value="active"
                @selected(old('status', $program->status ?? 'active') === 'active')>
                Active
            </option>

            <option value="inactive"
                @selected(old('status', $program->status ?? '') === 'inactive')>
                Inactive
            </option>
        </select>

        @error('status')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-slate-300 mb-2">
        Description
    </label>

    <textarea
        name="description"
        rows="5"
        class="w-full rounded-lg bg-slate-900 border border-slate-700
               text-white px-4 py-3"
    >{{ old('description', $program->description ?? '') }}</textarea>

    @error('description')
        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 flex justify-end gap-3">
    <a
        href="{{ route('admin.programs.index') }}"
        class="px-5 py-3 rounded-lg bg-slate-800 text-slate-300
               hover:bg-slate-700"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="px-5 py-3 rounded-lg bg-blue-600 text-white
               hover:bg-blue-500"
    >
        {{ $submitLabel }}
    </button>
</div>