<div class="row g-4">

    {{-- Name --}}
    <div class="col-md-8">

        <label for="name" class="form-label">
            Lead Source Name
            <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $leadSource->name ?? '') }}"
            placeholder="e.g. Website, Referral, Exhibition"
            required
        >

        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Status --}}
    <div class="col-md-4">

        <label for="is_active" class="form-label">
            Status
        </label>

        <select
            name="is_active"
            id="is_active"
            class="form-select @error('is_active') is-invalid @enderror"
        >

            <option value="1"
                {{ old('is_active', isset($leadSource) ? $leadSource->is_active : true) ? 'selected' : '' }}>
                Active
            </option>

            <option value="0"
                {{ old('is_active', isset($leadSource) ? $leadSource->is_active : true) ? '' : 'selected' }}>
                Inactive
            </option>

        </select>

        @error('is_active')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Description --}}
    <div class="col-12">

        <label for="description" class="form-label">
            Description
        </label>

        <textarea
            name="description"
            id="description"
            rows="5"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Enter a short description of this lead source..."
        >{{ old('description', $leadSource->description ?? '') }}</textarea>

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <div class="form-text">
            Example: Leads received through the company website contact form.
        </div>

    </div>

</div>