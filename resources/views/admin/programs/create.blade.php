@extends('admin.layouts.app')

@section('title', 'Create Program')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">
            Create Program
        </h1>

        <p class="text-slate-400 mt-1">
            Add a new FoxBrain program or product.
        </p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">

        <form
            method="POST"
            action="{{ route('admin.programs.store') }}"
        >
            @csrf

            @php
                $submitLabel = 'Create Program';
            @endphp

            @include('admin.programs._form')

        </form>

    </div>

</div>

@endsection