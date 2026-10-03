<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Dashboard') - {{ setting('site_name', 'FoxBrain ERP') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

</head>

<body class="bg-slate-950 text-slate-100 antialiased">

    <div class="min-h-screen flex bg-slate-950">

        {{-- SIDEBAR --}}
        @include('admin.layouts.sidebar')


        {{-- MAIN AREA --}}
        <div class="flex-1 min-w-0 flex flex-col bg-slate-950">

            {{-- TOPBAR --}}
            @include('admin.layouts.topbar')


            {{-- CONTENT --}}
            <main class="flex-1 bg-slate-950 p-4 sm:p-6">

                @yield('content')

            </main>

        </div>

    </div>

    @stack('scripts')

</body>

</html>