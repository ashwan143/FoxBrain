@extends('admin.layouts.app')

@section('title', 'Create Sales Employee')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">
            Create Sales Employee
        </h1>

        <p class="mt-1 text-sm text-slate-400">
            Add a sales employee to the FoxBrain sales team.
        </p>
    </div>

    <div class="rounded-xl border border-slate-800 bg-slate-900 p-6 shadow-xl">

        <form
            method="POST"
            action="{{ route('admin.sales-employees.store') }}"
        >

            @csrf

            @include(
                'admin.sales-employees._form',
                ['salesEmployee' => null]
            )

        </form>

    </div>

</div>

@endsection