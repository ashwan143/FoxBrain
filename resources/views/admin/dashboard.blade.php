@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- =====================================================
        HERO
    ====================================================== --}}
    <section class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-slate-900
                    via-slate-900 to-blue-950
                    border border-slate-800">

        {{-- Background decoration --}}
        <div class="absolute -right-20 -top-20
                    w-72 h-72 rounded-full
                    bg-blue-600/10 blur-3xl">
        </div>

        <div class="absolute right-20 bottom-0
                    w-48 h-48 rounded-full
                    bg-cyan-500/5 blur-3xl">
        </div>


        <div class="relative p-7 lg:p-8">

            <div class="max-w-3xl">

                <div class="flex items-center gap-2 mb-3">

                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>

                    <span class="text-xs uppercase tracking-[0.2em]
                                 font-semibold text-blue-400">

                        FoxBrain ERP

                    </span>

                </div>


                <h2 class="text-3xl lg:text-4xl font-bold text-white">

                    Welcome back,
                    {{ auth()->user()->name }}

                </h2>


                <p class="mt-3 text-sm leading-6 text-slate-400 max-w-2xl">

                    Manage your ERP operations, users, access control
                    and system configuration from one centralized workspace.

                </p>


                <div class="mt-6 flex flex-wrap gap-3">

                    @if(auth()->user()->hasPermission('users.view'))

                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center gap-2
                                  px-4 py-2.5 rounded-xl
                                  bg-blue-600 hover:bg-blue-500
                                  text-sm font-semibold text-white
                                  transition">

                            Manage Users

                            <span>→</span>

                        </a>

                    @endif


                    @if(auth()->user()->hasPermission('activity_logs.view'))

                        <a href="{{ route('admin.activity-logs.index') }}"
                           class="inline-flex items-center gap-2
                                  px-4 py-2.5 rounded-xl
                                  bg-slate-800 hover:bg-slate-700
                                  border border-slate-700
                                  text-sm font-semibold text-slate-200
                                  transition">

                            Activity Logs

                        </a>

                    @endif

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        KPI AREA
    ====================================================== --}}
    <section>

        <div class="flex items-center justify-between mb-4">

            <div>

                <p class="text-xs uppercase tracking-[0.2em]
                          text-slate-600 font-semibold">

                    Overview

                </p>

                <h3 class="mt-1 text-lg font-bold text-white">

                    System Metrics

                </h3>

            </div>

            <span class="text-xs text-slate-600">

                Live database data

            </span>

        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">


            {{-- USERS --}}
            <div class="rounded-2xl bg-slate-900
                        border border-slate-800
                        p-5">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-xs uppercase tracking-wider
                                  text-slate-500 font-semibold">

                            Users

                        </p>

                        <p class="mt-3 text-3xl font-bold text-white">

                            {{ number_format($stats['users']) }}

                        </p>

                    </div>


                    <div class="w-10 h-10 rounded-xl
                                bg-blue-500/10
                                text-blue-400
                                flex items-center justify-center">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-5a4 4 0 11-8 0 4 4 0 018 0z"/>

                        </svg>

                    </div>

                </div>

                <div class="mt-5 h-1 rounded-full bg-slate-800">

                    <div class="h-1 rounded-full bg-blue-500"
                         style="width: 72%;">
                    </div>

                </div>

                <p class="mt-2 text-xs text-slate-600">

                    Registered accounts

                </p>

            </div>


            {{-- ACTIVE USERS --}}
            <div class="rounded-2xl bg-slate-900
                        border border-slate-800
                        p-5">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-xs uppercase tracking-wider
                                  text-slate-500 font-semibold">

                            Active Users

                        </p>

                        <p class="mt-3 text-3xl font-bold text-white">

                            {{ number_format($stats['active_users']) }}

                        </p>

                    </div>


                    <div class="w-10 h-10 rounded-xl
                                bg-emerald-500/10
                                text-emerald-400
                                flex items-center justify-center">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                    </div>

                </div>

                <div class="mt-5 h-1 rounded-full bg-slate-800">

                    <div class="h-1 rounded-full bg-emerald-500"
                         style="width:
                         {{ $stats['users'] > 0
                            ? ($stats['active_users'] / $stats['users']) * 100
                            : 0 }}%;">
                    </div>

                </div>

                <p class="mt-2 text-xs text-slate-600">

                    Active accounts

                </p>

            </div>


            {{-- ROLES --}}
            <div class="rounded-2xl bg-slate-900
                        border border-slate-800
                        p-5">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-xs uppercase tracking-wider
                                  text-slate-500 font-semibold">

                            Roles

                        </p>

                        <p class="mt-3 text-3xl font-bold text-white">

                            {{ number_format($stats['roles']) }}

                        </p>

                    </div>


                    <div class="w-10 h-10 rounded-xl
                                bg-violet-500/10
                                text-violet-400
                                flex items-center justify-center">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 15l-3.5 2 1-4-3-2.5h4L12 7l1.5 3.5h4l-3 2.5 1 4L12 15z"/>

                        </svg>

                    </div>

                </div>

                <div class="mt-5 h-1 rounded-full bg-slate-800">

                    <div class="h-1 rounded-full bg-violet-500"
                         style="width: 65%;">
                    </div>

                </div>

                <p class="mt-2 text-xs text-slate-600">

                    Access roles

                </p>

            </div>


            {{-- PERMISSIONS --}}
            <div class="rounded-2xl bg-slate-900
                        border border-slate-800
                        p-5">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-xs uppercase tracking-wider
                                  text-slate-500 font-semibold">

                            Permissions

                        </p>

                        <p class="mt-3 text-3xl font-bold text-white">

                            {{ number_format($stats['permissions']) }}

                        </p>

                    </div>


                    <div class="w-10 h-10 rounded-xl
                                bg-amber-500/10
                                text-amber-400
                                flex items-center justify-center">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v2h8z"/>

                        </svg>

                    </div>

                </div>

                <div class="mt-5 h-1 rounded-full bg-slate-800">

                    <div class="h-1 rounded-full bg-amber-500"
                         style="width: 80%;">
                    </div>

                </div>

                <p class="mt-2 text-xs text-slate-600">

                    Access permissions

                </p>

            </div>

        </div>

    </section>


    {{-- =====================================================
        WORKSPACE
    ====================================================== --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">


        {{-- RECENT ACTIVITY --}}
        <section class="xl:col-span-2 rounded-2xl
                        bg-slate-900 border border-slate-800
                        overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-800">

                <div class="flex items-center justify-between">

                    <div>

                        <h3 class="font-bold text-white">

                            Recent Activity

                        </h3>

                        <p class="mt-1 text-xs text-slate-600">

                            Latest actions in the system

                        </p>

                    </div>


                    @if(auth()->user()->hasPermission('activity_logs.view'))

                        <a href="{{ route('admin.activity-logs.index') }}"
                           class="text-xs font-semibold text-blue-400
                                  hover:text-blue-300">

                            View all →

                        </a>

                    @endif

                </div>

            </div>


            <div class="divide-y divide-slate-800">

                @forelse($recentActivities as $activity)

                    <div class="px-6 py-4
                                hover:bg-slate-800/40 transition">

                        <div class="flex items-center gap-4">

                            <div class="w-9 h-9 rounded-lg
                                        bg-blue-500/10
                                        flex items-center justify-center
                                        flex-shrink-0">

                                <span class="w-2 h-2 rounded-full
                                             bg-blue-400">
                                </span>

                            </div>


                            <div class="flex-1 min-w-0">

                                <p class="text-sm font-medium
                                          text-slate-200 truncate">

                                    {{ $activity->description }}

                                </p>

                                <div class="flex flex-wrap gap-2 mt-1">

                                    @if($activity->user)

                                        <span class="text-xs text-slate-600">

                                            {{ $activity->user->name }}

                                        </span>

                                    @endif

                                    @if($activity->module)

                                        <span class="px-2 py-0.5 rounded-md
                                                     bg-slate-800
                                                     text-[10px]
                                                     text-slate-500">

                                            {{ ucfirst($activity->module) }}

                                        </span>

                                    @endif

                                    @if($activity->action)

                                        <span class="px-2 py-0.5 rounded-md
                                                     bg-blue-500/10
                                                     text-[10px]
                                                     text-blue-400">

                                            {{ ucfirst($activity->action) }}

                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="text-xs text-slate-600
                                        whitespace-nowrap">

                                {{ $activity->created_at?->diffForHumans() }}

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-12 text-center">

                        <p class="text-sm text-slate-500">

                            No activity recorded yet.

                        </p>

                    </div>

                @endforelse

            </div>

        </section>


        {{-- SYSTEM STATUS --}}
        <section class="rounded-2xl
                        bg-slate-900 border border-slate-800
                        overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-800">

                <p class="text-xs uppercase tracking-wider
                          text-slate-600 font-semibold">

                    System

                </p>

                <h3 class="mt-1 font-bold text-white">

                    System Status

                </h3>

            </div>


            <div class="p-5 space-y-3">


                {{-- Database --}}
                <div class="flex items-center justify-between
                            p-4 rounded-xl bg-slate-800/60">

                    <div class="flex items-center gap-3">

                        <span class="w-2.5 h-2.5 rounded-full
                                     bg-emerald-500">
                        </span>

                        <div>

                            <p class="text-sm font-medium text-slate-200">
                                Database
                            </p>

                            <p class="text-[10px] text-slate-600">
                                MySQL
                            </p>

                        </div>

                    </div>

                    <span class="text-xs text-emerald-400">
                        Online
                    </span>

                </div>


                {{-- Authentication --}}
                <div class="flex items-center justify-between
                            p-4 rounded-xl bg-slate-800/60">

                    <div class="flex items-center gap-3">

                        <span class="w-2.5 h-2.5 rounded-full
                                     bg-emerald-500">
                        </span>

                        <div>

                            <p class="text-sm font-medium text-slate-200">
                                Authentication
                            </p>

                            <p class="text-[10px] text-slate-600">
                                Laravel Breeze
                            </p>

                        </div>

                    </div>

                    <span class="text-xs text-emerald-400">
                        Active
                    </span>

                </div>


                {{-- RBAC --}}
                <div class="flex items-center justify-between
                            p-4 rounded-xl bg-slate-800/60">

                    <div class="flex items-center gap-3">

                        <span class="w-2.5 h-2.5 rounded-full
                                     bg-emerald-500">
                        </span>

                        <div>

                            <p class="text-sm font-medium text-slate-200">
                                RBAC
                            </p>

                            <p class="text-[10px] text-slate-600">
                                Roles & permissions
                            </p>

                        </div>

                    </div>

                    <span class="text-xs text-emerald-400">
                        Active
                    </span>

                </div>


                {{-- Activity --}}
                <div class="flex items-center justify-between
                            p-4 rounded-xl bg-slate-800/60">

                    <div class="flex items-center gap-3">

                        <span class="w-2.5 h-2.5 rounded-full
                                     bg-blue-500">
                        </span>

                        <div>

                            <p class="text-sm font-medium text-slate-200">
                                Activity Logging
                            </p>

                            <p class="text-[10px] text-slate-600">
                                Audit trail
                            </p>

                        </div>

                    </div>

                    <span class="text-xs text-blue-400">
                        Enabled
                    </span>

                </div>

            </div>

        </section>

    </div>


    {{-- =====================================================
        QUICK ACCESS
    ====================================================== --}}
    <section>

        <div class="mb-4">

            <p class="text-xs uppercase tracking-[0.2em]
                      text-slate-600 font-semibold">

                Workspace

            </p>

            <h3 class="mt-1 text-lg font-bold text-white">

                Quick Access

            </h3>

        </div>


        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


            @if(auth()->user()->hasPermission('users.view'))

                <a href="{{ route('admin.users.index') }}"
                   class="group p-5 rounded-2xl
                          bg-slate-900 border border-slate-800
                          hover:border-blue-500/50
                          hover:bg-slate-800
                          transition">

                    <div class="w-10 h-10 rounded-xl
                                bg-blue-500/10
                                text-blue-400
                                flex items-center justify-center
                                group-hover:bg-blue-600
                                group-hover:text-white
                                transition">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-5a4 4 0 11-8 0 4 4 0 018 0z"/>

                        </svg>

                    </div>

                    <p class="mt-4 text-sm font-semibold text-white">
                        Users
                    </p>

                    <p class="mt-1 text-xs text-slate-600">
                        Manage accounts
                    </p>

                </a>

            @endif


            @if(auth()->user()->hasPermission('roles.view'))

                <a href="{{ route('admin.roles.index') }}"
                   class="group p-5 rounded-2xl
                          bg-slate-900 border border-slate-800
                          hover:border-violet-500/50
                          hover:bg-slate-800
                          transition">

                    <div class="w-10 h-10 rounded-xl
                                bg-violet-500/10
                                text-violet-400
                                flex items-center justify-center
                                group-hover:bg-violet-600
                                group-hover:text-white
                                transition">

                        <span class="font-bold">
                            R
                        </span>

                    </div>

                    <p class="mt-4 text-sm font-semibold text-white">
                        Roles
                    </p>

                    <p class="mt-1 text-xs text-slate-600">
                        Manage access roles
                    </p>

                </a>

            @endif


            @if(auth()->user()->hasPermission('permissions.view'))

                <a href="{{ route('admin.permissions.index') }}"
                   class="group p-5 rounded-2xl
                          bg-slate-900 border border-slate-800
                          hover:border-amber-500/50
                          hover:bg-slate-800
                          transition">

                    <div class="w-10 h-10 rounded-xl
                                bg-amber-500/10
                                text-amber-400
                                flex items-center justify-center
                                group-hover:bg-amber-600
                                group-hover:text-white
                                transition">

                        <span class="font-bold">
                            P
                        </span>

                    </div>

                    <p class="mt-4 text-sm font-semibold text-white">
                        Permissions
                    </p>

                    <p class="mt-1 text-xs text-slate-600">
                        Manage access rules
                    </p>

                </a>

            @endif


            @if(auth()->user()->hasPermission('settings.view'))

                <a href="{{ route('admin.settings.index') }}"
                   class="group p-5 rounded-2xl
                          bg-slate-900 border border-slate-800
                          hover:border-emerald-500/50
                          hover:bg-slate-800
                          transition">

                    <div class="w-10 h-10 rounded-xl
                                bg-emerald-500/10
                                text-emerald-400
                                flex items-center justify-center
                                group-hover:bg-emerald-600
                                group-hover:text-white
                                transition">

                        <span class="font-bold">
                            S
                        </span>

                    </div>

                    <p class="mt-4 text-sm font-semibold text-white">
                        Settings
                    </p>

                    <p class="mt-1 text-xs text-slate-600">
                        System configuration
                    </p>

                </a>

            @endif

        </div>

    </section>


    {{-- =====================================================
        FOOTER
    ====================================================== --}}
    <div class="pt-2 pb-3 flex items-center justify-between">

        <span class="text-[10px] text-slate-700">

            {{ setting('company_name', 'FoxBrain Pvt. Ltd.') }}

        </span>

        <span class="text-[10px] text-slate-700">

            FoxBrain ERP

        </span>

    </div>

</div>

@endsection