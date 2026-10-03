@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page_title', 'Edit User')

@section('content')

<div class="max-w-3xl">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="px-6 py-5 border-b border-gray-200">

            <h2 class="text-xl font-semibold text-gray-800">
                Edit User
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Update user information and access.
            </p>

        </div>


        <form method="POST"
              action="{{ route('admin.users.update', $user) }}"
              class="p-6 space-y-6">

            @csrf
            @method('PUT')


            @include('admin.users._form')


            <div class="flex justify-end gap-3">

                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection