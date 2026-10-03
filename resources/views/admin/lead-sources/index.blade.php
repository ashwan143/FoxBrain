@extends('admin.layouts.app')

@section('title', 'Lead Sources')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Lead Sources
            </h1>

            <p class="mt-1 text-sm text-slate-400">
                Manage the sources used to capture and track sales leads.
            </p>
        </div>

        @if(auth()->user()->hasPermission('lead_sources.create'))

            <a
                href="{{ route('admin.lead-sources.create') }}"
                class="inline-flex items-center justify-center rounded-lg
                       bg-blue-600 px-5 py-3 text-sm font-semibold text-white
                       hover:bg-blue-500"
            >
                + Add Lead Source
            </a>

        @endif

    </div>


    {{-- Flash Messages --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-800 bg-green-950/50
                    px-4 py-3 text-sm text-green-300">

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="rounded-lg border border-red-800 bg-red-950/50
                    px-4 py-3 text-sm text-red-300">

            {{ session('error') }}

        </div>

    @endif


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-lg border border-red-800 bg-red-950/50
                    px-4 py-3 text-sm text-red-300">

            <ul class="list-disc space-y-1 pl-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-800 bg-slate-900 p-5">

        <form
            method="GET"
            action="{{ route('admin.lead-sources.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-4"
        >

            {{-- Search --}}
            <div class="md:col-span-2">

                <label class="mb-2 block text-sm text-slate-400">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Source name, description..."
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-950 px-4 py-3 text-slate-100
                           placeholder-slate-500
                           focus:border-blue-500 focus:ring-blue-500"
                >

            </div>


            {{-- Status --}}
            <div>

                <label class="mb-2 block text-sm text-slate-400">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-950 px-4 py-3 text-slate-100
                           focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        All Statuses
                    </option>

                    <option
                        value="1"
                        @selected(request('status') === '1')
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        @selected(request('status') === '0')
                    >
                        Inactive
                    </option>

                </select>

            </div>


            {{-- Buttons --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="rounded-lg bg-slate-700 px-5 py-3 text-sm
                           font-medium text-white hover:bg-slate-600"
                >
                    Filter
                </button>

                <a
                    href="{{ route('admin.lead-sources.index') }}"
                    class="rounded-lg bg-slate-800 px-5 py-3 text-sm
                           font-medium text-slate-300 hover:bg-slate-700"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-800">

                <thead class="bg-slate-950">

                    <tr>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400"
                        >
                            Source
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400"
                        >
                            Description
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400"
                        >
                            Leads
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400"
                        >
                            Status
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold
                                   uppercase tracking-wider text-slate-400"
                        >
                            Created
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-400"
                        >
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-800">

                    @forelse($leadSources as $leadSource)

                        <tr class="hover:bg-slate-800/40">

                            {{-- Source --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-10 w-10 items-center justify-center
                                               rounded-lg bg-blue-950 text-sm
                                               font-bold text-blue-400"
                                    >
                                        {{ strtoupper(substr($leadSource->name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <div class="font-medium text-white">
                                            {{ $leadSource->name }}
                                        </div>

                                        <div class="text-xs text-slate-500">
                                            ID #{{ $leadSource->id }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Description --}}
                            <td class="max-w-md px-6 py-4">

                                <div class="text-sm text-slate-300">

                                    {{ $leadSource->description ?: 'No description added.' }}

                                </div>

                            </td>


                            {{-- Leads --}}
                            <td class="px-6 py-4">

                                <span
                                    class="inline-flex min-w-[40px] justify-center
                                           rounded-lg bg-slate-800 px-3 py-1.5
                                           text-sm font-semibold text-slate-200"
                                >
                                    {{ $leadSource->leads_count }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if($leadSource->is_active)

                                    <span
                                        class="inline-flex items-center gap-2
                                               rounded-full border border-green-800
                                               bg-green-950 px-3 py-1
                                               text-xs font-medium text-green-300"
                                    >

                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-green-400"
                                        ></span>

                                        Active

                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-2
                                               rounded-full border border-slate-700
                                               bg-slate-800 px-3 py-1
                                               text-xs font-medium text-slate-300"
                                    >

                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-slate-500"
                                        ></span>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- Created --}}
                            <td class="px-6 py-4 text-sm text-slate-400">

                                {{ $leadSource->created_at?->format('d M Y') ?? '—' }}

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    @if(auth()->user()->hasPermission('lead_sources.edit'))

                                        <a
                                            href="{{ route(
                                                'admin.lead-sources.edit',
                                                $leadSource
                                            ) }}"
                                            class="rounded-lg bg-slate-800 px-3 py-2
                                                   text-sm text-slate-300
                                                   hover:bg-slate-700"
                                        >
                                            Edit
                                        </a>

                                    @endif


                                    @if(auth()->user()->hasPermission('lead_sources.delete'))

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.lead-sources.destroy',
                                                $leadSource
                                            ) }}"
                                            onsubmit="return confirm(
                                                'Delete this lead source?'
                                            );"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-950 px-3 py-2
                                                       text-sm text-red-300
                                                       hover:bg-red-900"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center text-slate-500"
                            >
                                No lead sources found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($leadSources->hasPages())

            <div class="border-t border-slate-800 px-6 py-4">

                {{ $leadSources->links() }}

            </div>

        @endif

    </div>

</div>

@endsection