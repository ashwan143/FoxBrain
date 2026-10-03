@extends('admin.layouts.app')

@section('title', 'Create User')
@section('page_title', 'Create User')

@section('content')

<div class="max-w-3xl">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="px-6 py-5 border-b border-gray-200">

            <h2 class="text-xl font-semibold text-gray-800">
                Create User
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Create a new FoxBrain ERP user.
            </p>

        </div>


        <form method="POST"
              action="{{ route('admin.users.store') }}"
              class="p-6 space-y-6">

            @csrf


            @include('admin.users._form')


            <div class="flex justify-end gap-3">

                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Create User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection