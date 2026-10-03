@extends('admin.layouts.app')

@section('title', 'Create Permission')

@section('content')

<div class="max-w-3xl">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Create Permission
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Add a new system permission.
        </p>

    </div>

    <form
        method="POST"
        action="{{ route('admin.permissions.store') }}">

        @csrf

        @include('admin.permissions._form')

    </form>

</div>

@endsection