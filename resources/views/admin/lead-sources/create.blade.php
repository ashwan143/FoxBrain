@extends('admin.layouts.app')

@section('title', 'Create Lead Source')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Create Lead Source</h1>

            <p class="text-muted mb-0">
                Add a new source for tracking where leads come from.
            </p>
        </div>

        <a href="{{ route('admin.lead-sources.index') }}"
           class="btn btn-outline-secondary">
            ← Back
        </a>

    </div>

    {{-- Form Card --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0">
                Lead Source Information
            </h5>

        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.lead-sources.store') }}">

                @csrf

                @include('admin.lead-sources._form')

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('admin.lead-sources.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Save Lead Source
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection