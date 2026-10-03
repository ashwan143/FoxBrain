<div class="grid grid-cols-1 md:grid-cols-2 gap-6">


    {{-- Name --}}
    <div>

        <label for="name"
               class="block text-sm font-medium text-gray-700 mb-2">
            Name
        </label>

        <input type="text"
               id="name"
               name="name"
               value="{{ old('name', $user->name ?? '') }}"
               required
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

        @error('name')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Email --}}
    <div>

        <label for="email"
               class="block text-sm font-medium text-gray-700 mb-2">
            Email
        </label>

        <input type="email"
               id="email"
               name="email"
               value="{{ old('email', $user->email ?? '') }}"
               required
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

        @error('email')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Phone --}}
    <div>

        <label for="phone"
               class="block text-sm font-medium text-gray-700 mb-2">
            Phone
        </label>

        <input type="text"
               id="phone"
               name="phone"
               value="{{ old('phone', $user->phone ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

        @error('phone')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Role --}}
    <div>

        <label for="role_id"
               class="block text-sm font-medium text-gray-700 mb-2">
            Role
        </label>

        <select id="role_id"
                name="role_id"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

            <option value="">
                Select Role
            </option>

            @foreach($roles as $role)

                <option value="{{ $role->id }}"
                    @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                    {{ $role->name }}
                </option>

            @endforeach

        </select>

        @error('role_id')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Password --}}
    <div>

        <label for="password"
               class="block text-sm font-medium text-gray-700 mb-2">
            Password
            @isset($user)
                <span class="text-gray-400">(leave empty to keep current)</span>
            @endif
        </label>

        <input type="password"
               id="password"
               name="password"
               {{ isset($user) ? '' : 'required' }}
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

        @error('password')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Password Confirmation --}}
    <div>

        <label for="password_confirmation"
               class="block text-sm font-medium text-gray-700 mb-2">
            Confirm Password
        </label>

        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               {{ isset($user) ? '' : 'required' }}
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

    </div>


    {{-- Status --}}
    <div>

        <label for="status"
               class="block text-sm font-medium text-gray-700 mb-2">
            Status
        </label>

        <select id="status"
                name="status"
                required
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

            @foreach(['active', 'inactive', 'suspended'] as $status)

                <option value="{{ $status }}"
                    @selected(old('status', $user->status ?? 'active') === $status)>
                    {{ ucfirst($status) }}
                </option>

            @endforeach

        </select>

        @error('status')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror

    </div>

</div>