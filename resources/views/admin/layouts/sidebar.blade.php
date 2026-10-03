<aside class="w-64 bg-slate-950 text-white min-h-screen flex-shrink-0
              border-r border-slate-800 flex flex-col">

    {{-- =========================================================
        BRAND
    ========================================================== --}}
    <div class="px-5 py-5 border-b border-slate-800">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl
                        bg-gradient-to-br from-blue-600 to-cyan-400
                        flex items-center justify-center
                        shadow-lg shadow-blue-500/20">

                <span class="text-white text-lg font-black">
                    F
                </span>

            </div>

            <div class="min-w-0">

                <div class="text-lg font-bold text-white truncate">
                    {{ setting('site_name', 'FoxBrain ERP') }}
                </div>

                <div class="text-[10px] uppercase tracking-wider text-slate-500">
                    Administration
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        NAVIGATION
    ========================================================== --}}
    <nav class="flex-1 overflow-y-auto p-3 space-y-1">


        {{-- =====================================================
            MAIN
        ====================================================== --}}
        <div class="px-3 pt-2 pb-2 text-[10px] font-bold
                    uppercase tracking-[0.18em] text-slate-600">

            Main

        </div>


        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center gap-3 px-3 py-3 rounded-xl
                  transition-all duration-200
                  {{ request()->routeIs('admin.dashboard')
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
                        : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">

            <div class="w-9 h-9 rounded-lg flex items-center justify-center
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-white/10'
                            : 'bg-slate-900 group-hover:bg-slate-800' }}">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0V15a2 2 0 012-2h0a2 2 0 012 2v5m-4 0h4"/>

                </svg>

            </div>

            <span class="text-sm font-medium">
                Dashboard
            </span>

        </a>


        {{-- =====================================================
            MANAGEMENT
        ====================================================== --}}
        <div class="px-3 pt-6 pb-2 text-[10px] font-bold
                    uppercase tracking-[0.18em] text-slate-600">

            Management

        </div>


        {{-- Users --}}
        @can('viewAny', App\Models\User::class)

            <a href="{{ route('admin.users.index') }}"
               class="group flex items-center gap-3 px-3 py-3 rounded-xl
                      transition-all duration-200
                      {{ request()->routeIs('admin.users.*')
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
                            : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">

                <div class="w-9 h-9 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.users.*')
                                ? 'bg-white/10'
                                : 'bg-slate-900 group-hover:bg-slate-800' }}">

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

                <span class="text-sm font-medium">
                    Users
                </span>

            </a>

        @endcan


        {{-- Roles --}}
        @if(auth()->user()->hasPermission('roles.view'))

            <a href="{{ route('admin.roles.index') }}"
               class="group flex items-center gap-3 px-3 py-3 rounded-xl
                      transition-all duration-200
                      {{ request()->routeIs('admin.roles.*')
                            ? 'bg-violet-600 text-white shadow-lg shadow-violet-600/20'
                            : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">

                <div class="w-9 h-9 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.roles.*')
                                ? 'bg-white/10'
                                : 'bg-slate-900 group-hover:bg-slate-800' }}">

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

                <span class="text-sm font-medium">
                    Roles
                </span>

            </a>

        @endif


        {{-- Permissions --}}
        @if(auth()->user()->hasPermission('permissions.view'))

            <a href="{{ route('admin.permissions.index') }}"
               class="group flex items-center gap-3 px-3 py-3 rounded-xl
                      transition-all duration-200
                      {{ request()->routeIs('admin.permissions.*')
                            ? 'bg-amber-600 text-white shadow-lg shadow-amber-600/20'
                            : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">

                <div class="w-9 h-9 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.permissions.*')
                                ? 'bg-white/10'
                                : 'bg-slate-900 group-hover:bg-slate-800' }}">

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

                <span class="text-sm font-medium">
                    Permissions
                </span>

            </a>

        @endif


        {{-- =====================================================
            SYSTEM
        ====================================================== --}}
        <div class="px-3 pt-6 pb-2 text-[10px] font-bold
                    uppercase tracking-[0.18em] text-slate-600">

            System

        </div>


        {{-- Settings --}}
        @if(auth()->user()->hasPermission('settings.view'))

            <a href="{{ route('admin.settings.index') }}"
               class="group flex items-center gap-3 px-3 py-3 rounded-xl
                      transition-all duration-200
                      {{ request()->routeIs('admin.settings.*')
                            ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20'
                            : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">

                <div class="w-9 h-9 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.settings.*')
                                ? 'bg-white/10'
                                : 'bg-slate-900 group-hover:bg-slate-800' }}">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.827 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.065 2.573c.94 1.543-.827 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.572-1.065c-1.543.94-3.31-.827-2.37-2.37a1.724 1.724 0 001.066-2.573c-1.756-.426-2.924-1.756-2.37-2.572.608-.996.07-2.296-1.066-2.572z"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                    </svg>

                </div>

                <span class="text-sm font-medium">
                    Settings
                </span>

            </a>

        @endif


        {{-- Activity Logs --}}
        @if(auth()->user()->hasPermission('activity_logs.view'))

            <a href="{{ route('admin.activity-logs.index') }}"
               class="group flex items-center gap-3 px-3 py-3 rounded-xl
                      transition-all duration-200
                      {{ request()->routeIs('admin.activity-logs.*')
                            ? 'bg-cyan-600 text-white shadow-lg shadow-cyan-600/20'
                            : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">

                <div class="w-9 h-9 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.activity-logs.*')
                                ? 'bg-white/10'
                                : 'bg-slate-900 group-hover:bg-slate-800' }}">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>

                    </svg>

                </div>

                <span class="text-sm font-medium">
                    Activity Logs
                </span>

            </a>

        @endif



         {{-- =====================================================
            SYSTEM
        ====================================================== --}}
        <div class="px-3 pt-6 pb-2 text-[10px] font-bold
                    uppercase tracking-[0.18em] text-slate-600">

            Sales Management

        </div>


        @if(auth()->user()->hasPermission('programs.view'))
    <a
        href="{{ route('admin.programs.index') }}"
        class="block px-4 py-3 rounded-lg
        {{ request()->routeIs('admin.programs.*')
            ? 'bg-blue-600 text-white'
            : 'text-gray-300 hover:bg-gray-800' }}"
    >
        Programs / Products
    </a>
@endif

@if(auth()->user()->hasPermission('sales_employees.view'))

    <a
        href="{{ route('admin.sales-employees.index') }}"
        class="block px-4 py-3 rounded-lg
        {{ request()->routeIs('admin.sales-employees.*')
            ? 'bg-blue-600 text-white'
            : 'text-gray-300 hover:bg-gray-800' }}"
    >
        Sales Employees
    </a>

@endif


@if(auth()->user()->hasPermission('lead_sources.view'))

    <a
        href="{{ route('admin.lead-sources.index') }}"
        class="block px-4 py-3 rounded-lg
        {{ request()->routeIs('admin.lead-sources.*')
            ? 'bg-blue-600 text-white'
            : 'text-gray-300 hover:bg-gray-800' }}"
    >
        Lead Sources
    </a>

@endif


@if(auth()->user()->hasPermission('leads.view'))

  

    <a
        href="{{ route('admin.leads.index') }}"
        class="block px-4 py-3 rounded-lg
        {{ request()->routeIs('admin.leads.*')
            ? 'bg-blue-600 text-white'
            : 'text-gray-300 hover:bg-gray-800' }}"
    >
        Leads   
    </a>

@endif

    </nav>


    {{-- =========================================================
        SIDEBAR FOOTER
    ========================================================== --}}
    <div class="p-3 border-t border-slate-800">

        <div class="px-3 py-3 rounded-xl bg-slate-900 border border-slate-800">

            <div class="flex items-center gap-2">

                <span class="relative flex h-2 w-2">

                    <span class="animate-ping absolute inline-flex
                                 h-full w-full rounded-full
                                 bg-emerald-400 opacity-50">
                    </span>

                    <span class="relative inline-flex rounded-full
                                 h-2 w-2 bg-emerald-500">
                    </span>

                </span>

                <span class="text-[11px] font-medium text-slate-400">
                    System Online
                </span>

            </div>

            <div class="mt-1 text-[10px] text-slate-600">
                {{ setting('company_name', 'FoxBrain Pvt. Ltd.') }}
            </div>

        </div>

    </div>

</aside>