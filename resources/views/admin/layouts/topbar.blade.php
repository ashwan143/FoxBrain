<header class="h-[73px] flex-shrink-0
               bg-slate-900
               border-b border-slate-800">

    <div class="h-full px-6 flex items-center justify-between">

        {{-- LEFT --}}
        <div>

            <h1 class="text-lg font-semibold text-white">

                @yield('page_title', 'Dashboard')

            </h1>

            <p class="text-xs text-slate-500 mt-0.5">

                {{ setting('company_name', 'FoxBrain Pvt. Ltd.') }}

            </p>

        </div>


        {{-- RIGHT --}}
        <div class="flex items-center gap-5">

            {{-- SYSTEM STATUS --}}
            <div class="hidden md:flex items-center gap-2
                        px-3 py-2 rounded-lg
                        bg-slate-950
                        border border-slate-800">

                <span class="relative flex h-2 w-2">

                    <span class="animate-ping absolute
                                 inline-flex h-full w-full
                                 rounded-full bg-emerald-400
                                 opacity-50">
                    </span>

                    <span class="relative inline-flex
                                 rounded-full h-2 w-2
                                 bg-emerald-500">
                    </span>

                </span>

                <span class="text-xs text-slate-400">
                    System Online
                </span>

            </div>


            {{-- USER --}}
            <div class="flex items-center gap-3">

                <div class="text-right hidden sm:block">

                    <div class="text-sm font-semibold text-slate-200">

                        {{ auth()->user()->name }}

                    </div>

                    <div class="text-xs text-slate-500">

                        {{ auth()->user()->role?->name ?? 'User' }}

                    </div>

                </div>


                {{-- AVATAR --}}
                <div class="w-9 h-9 rounded-full
                            bg-gradient-to-br
                            from-blue-600 to-cyan-400
                            flex items-center justify-center
                            text-sm font-bold text-white">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            </div>

        </div>

    </div>

</header>