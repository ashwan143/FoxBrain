@extends('admin.layouts.app')

@section('title', 'Edit Permission')

@section('content')

<div class="max-w-3xl">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Edit Permission
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Update permission information.
        </p>

    </div>

    <form
        method="POST"
        action="{{ route('admin.permissions.update', $permission) }}">

        @csrf
        @method('PUT')

        @include('admin.permissions._form')

    </form>

</div>

@endsection
s