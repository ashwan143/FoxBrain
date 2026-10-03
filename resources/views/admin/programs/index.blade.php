@extends('admin.layouts.app')

@section('title', 'Programs')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center
                md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Programs / Products
            </h1>

            <p class="text-slate-400 mt-1">
                Manage FoxBrain programs and products.
            </p>
        </div>

        @if(auth()->user()->hasPermission('programs.create'))
            <a
                href="{{ route('admin.programs.create') }}"
                class="inline-flex items-center justify-center
                       px-5 py-3 rounded-lg bg-blue-600
                       text-white hover:bg-blue-500"
            >
                + Add Program
            </a>
        @endif

    </div>

    @if(session('success'))
        <div class="bg-emerald-900/40 border border-emerald-700
                    text-emerald-300 rounded-lg px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-4">

        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Search program, code..."
                class="rounded-lg bg-slate-950 border border-slate-700
                       text-white px-4 py-3"
            >

            <select
                name="status"
                class="rounded-lg bg-slate-950 border border-slate-700
                       text-white px-4 py-3"
            >
                <option value="">All Statuses</option>

                <option value="active" @selected($status === 'active')>
                    Active
                </option>

                <option value="inactive" @selected($status === 'inactive')>
                    Inactive
                </option>
            </select>

            <div class="flex gap-2">

                <button
                    type="submit"
                    class="px-5 py-3 rounded-lg bg-slate-700
                           text-white hover:bg-slate-600"
                >
                    Search
                </button>

                <a
                    href="{{ route('admin.programs.index') }}"
                    class="px-5 py-3 rounded-lg bg-slate-800
                           text-slate-300 hover:bg-slate-700"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>

    <div class="bg-slate-900 border border-slate-800
                rounded-xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-slate-950 border-b border-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-sm text-slate-400">
                            Program
                        </th>

                        <th class="px-6 py-4 text-sm text-slate-400">
                            Code
                        </th>

                        <th class="px-6 py-4 text-sm text-slate-400">
                            Duration
                        </th>

                        <th class="px-6 py-4 text-sm text-slate-400">
                            Default Fee
                        </th>

                        <th class="px-6 py-4 text-sm text-slate-400">
                            Status
                        </th>

                        <th class="px-6 py-4 text-sm text-slate-400 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-800">

                    @forelse($programs as $program)

                        <tr class="hover:bg-slate-800/40">

                            <td class="px-6 py-4">

                                <div class="font-medium text-white">
                                    {{ $program->name }}
                                </div>

                                @if($program->description)
                                    <div class="text-sm text-slate-500 mt-1">
                                        {{ Str::limit($program->description, 80) }}
                                    </div>
                                @endif

                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ $program->code ?: '—' }}
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ $program->duration_months
                                    ? $program->duration_months . ' months'
                                    : '—' }}
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                ₹{{ number_format($program->default_fee, 2) }}
                            </td>

                            <td class="px-6 py-4">

                                @if($program->status === 'active')

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 text-xs bg-emerald-900/50
                                                 text-emerald-300">
                                        Active
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 text-xs bg-slate-800
                                                 text-slate-400">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    @if(auth()->user()->hasPermission('programs.edit'))

                                        <a
                                            href="{{ route('admin.programs.edit', $program) }}"
                                            class="px-3 py-2 rounded-lg bg-slate-800
                                                   text-slate-300 hover:bg-slate-700"
                                        >
                                            Edit
                                        </a>

                                    @endif

                                    @if(auth()->user()->hasPermission('programs.delete'))

                                        <form
                                            method="POST"
                                            action="{{ route('admin.programs.destroy', $program) }}"
                                            onsubmit="return confirm('Delete this program?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="px-3 py-2 rounded-lg
                                                       bg-red-900/40 text-red-300
                                                       hover:bg-red-900/70"
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
                                No programs found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="px-6 py-4 border-t border-slate-800">
            {{ $programs->links() }}
        </div>

    </div>

</div>

@endsection