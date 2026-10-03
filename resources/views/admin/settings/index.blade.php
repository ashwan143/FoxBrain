@extends('admin.layouts.app')

@section('title', 'System Settings')

@section('content')

<div class="max-w-6xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            System Settings
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Configure your FoxBrain ERP system.
        </p>
    </div>

    @if(session('success'))

        <div class="mb-5 rounded-lg bg-green-100 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>

    @endif

    @if($errors->any())

        <div class="mb-5 rounded-lg bg-red-100 text-red-800 px-4 py-3">

            <ul class="list-disc ml-5">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <form
        method="POST"
        action="{{ route('admin.settings.update') }}"
    >

        @csrf
        @method('PUT')

        {{-- General --}}

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

            <h2 class="text-lg font-semibold text-gray-800 mb-5">
                General Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Site Name
                    </label>

                    <input
                        type="text"
                        name="site_name"
                        value="{{ old('site_name', $settings['site_name']) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Company Name
                    </label>

                    <input
                        type="text"
                        name="company_name"
                        value="{{ old('company_name', $settings['company_name']) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                </div>

            </div>

        </div>


        {{-- Contact --}}

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

            <h2 class="text-lg font-semibold text-gray-800 mb-5">
                Contact Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>

                    <input
                        type="email"
                        name="site_email"
                        value="{{ old('site_email', $settings['site_email']) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Phone
                    </label>

                    <input
                        type="text"
                        name="site_phone"
                        value="{{ old('site_phone', $settings['site_phone']) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                </div>

            </div>

        </div>


        {{-- Localization --}}

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

            <h2 class="text-lg font-semibold text-gray-800 mb-5">
                Localization
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Currency
                    </label>

                    <input
                        type="text"
                        name="currency"
                        value="{{ old('currency', $settings['currency']) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Timezone
                    </label>

                    <select
                        name="timezone"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                        @foreach([
                            'Asia/Kolkata' => 'India (Asia/Kolkata)',
                            'UTC' => 'UTC',
                            'Asia/Dubai' => 'Dubai',
                            'Asia/Singapore' => 'Singapore',
                            'Europe/London' => 'London',
                            'America/New_York' => 'New York'
                        ] as $value => $label)

                            <option
                                value="{{ $value }}"
                                {{ old('timezone', $settings['timezone']) === $value ? 'selected' : '' }}
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Date Format
                    </label>

                    <select
                        name="date_format"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                        @foreach([
                            'd-m-Y' => '31-12-2026',
                            'Y-m-d' => '2026-12-31',
                            'd/m/Y' => '31/12/2026',
                            'm/d/Y' => '12/31/2026'
                        ] as $value => $label)

                            <option
                                value="{{ $value }}"
                                {{ old('date_format', $settings['date_format']) === $value ? 'selected' : '' }}
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>


        {{-- Actions --}}

        @if(auth()->user()->hasPermission('settings.edit'))

            <div class="flex justify-end">

                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                >
                    Save Settings
                </button>

            </div>

        @endif

    </form>

</div>

@endsection