<div class="bg-white rounded-xl shadow-sm p-6 space-y-6">

    {{-- Basic Information --}}

    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Basic Information
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Role Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $role->name ?? '') }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required
                >

                @error('name')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Slug
                </label>

                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug', $role->slug ?? '') }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required
                >

                @error('slug')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <div class="mt-5">

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>

            <textarea
                name="description"
                rows="3"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            >{{ old('description', $role->description ?? '') }}</textarea>

            @error('description')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <div class="mt-5">

            <label class="flex items-center gap-2">

                <input
                    type="hidden"
                    name="is_active"
                    value="0"
                >

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    {{ old('is_active', $role->is_active ?? true) ? 'checked' : '' }}
                >

                <span class="text-sm text-gray-700">
                    Active Role
                </span>

            </label>

        </div>

    </div>


    {{-- Permissions --}}

    <div>

        <div class="flex items-center justify-between mb-4">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Permissions
                </h2>

                <p class="text-sm text-gray-500">
                    Select the permissions this role should have.
                </p>
            </div>

            <button
                type="button"
                onclick="toggleAllPermissions()"
                class="text-sm text-blue-600 hover:underline">
                Select / Unselect All
            </button>

        </div>

        @php
            $selectedPermissions = old(
                'permissions',
                isset($role)
                    ? $role->permissions->pluck('id')->toArray()
                    : []
            );
        @endphp

        <div class="space-y-5">

            @foreach($permissions as $module => $modulePermissions)

                <div class="border rounded-lg overflow-hidden">

                    <div class="bg-gray-50 px-4 py-3 border-b">

                        <h3 class="font-semibold text-gray-800 capitalize">
                            {{ str_replace('_', ' ', $module ?: 'General') }}
                        </h3>

                    </div>

                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">

                        @foreach($modulePermissions as $permission)

                            <label class="flex items-start gap-2 cursor-pointer">

                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    class="permission-checkbox mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}
                                >

                                <span>
                                    <span class="block text-sm font-medium text-gray-700">
                                        {{ $permission->name }}
                                    </span>

                                    <span class="block text-xs text-gray-500">
                                        {{ $permission->slug }}
                                    </span>
                                </span>

                            </label>

                        @endforeach

                    </div>

                </div>

            @endforeach

        </div>

        @error('permissions')
            <p class="text-red-600 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- Buttons --}}

    <div class="flex items-center justify-end gap-3 pt-4 border-t">

        <a
            href="{{ route('admin.roles.index') }}"
            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
            Cancel
        </a>

        <button
            type="submit"
            class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">

            {{ isset($role) ? 'Update Role' : 'Create Role' }}

        </button>

    </div>

</div>


<script>
function toggleAllPermissions() {
    const checkboxes = document.querySelectorAll('.permission-checkbox');

    const shouldCheck = [...checkboxes].some(
        checkbox => !checkbox.checked
    );

    checkboxes.forEach(checkbox => {
        checkbox.checked = shouldCheck;
    });
}
</script>