@extends('admin.layouts.app')

@section('title', 'Edit Role')

@section('content')

<div class="max-w-5xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Edit Role
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Update role information and permissions.
        </p>
    </div>

    <form method="POST"
          action="{{ route('admin.roles.update', $role) }}">

        @csrf
        @method('PUT')

        @include('admin.roles._form')

    </form>

</div>

@endsection