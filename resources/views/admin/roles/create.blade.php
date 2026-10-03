@extends('admin.layouts.app')

@section('title', 'Create Role')

@section('content')

<div class="max-w-5xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Create Role
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Create a role and assign permissions.
        </p>
    </div>

    <form method="POST"
          action="{{ route('admin.roles.store') }}">

        @csrf

        @include('admin.roles._form')

    </form>

</div>

@endsection