@extends('admin.layouts.app')

@section('title', 'Create Lead')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Create Lead</h1>

            <p class="text-muted mb-0">
                Add a new school sales opportunity.
            </p>
        </div>

        <a
            href="{{ route('admin.leads.index') }}"
            class="btn btn-outline-secondary"
        >
            Back to Leads
        </a>

    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.leads.store') }}"
    >
        @csrf

        @include('admin.leads._form')

        <div class="d-flex justify-content-end gap-2 mt-4">

            <a
                href="{{ route('admin.leads.index') }}"
                class="btn btn-light"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Create Lead
            </button>

        </div>

    </form>

</div>

@endsection