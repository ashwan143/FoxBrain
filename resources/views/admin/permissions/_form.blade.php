<div class="bg-white rounded-xl shadow-sm p-6">

    <div class="space-y-5">

        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Permission Name
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $permission->name ?? '') }}"
                placeholder="View Users"
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
                Permission Slug
            </label>

            <input
                type="text"
                name="slug"
                value="{{ old('slug', $permission->slug ?? '') }}"
                placeholder="users.view"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                required
            >

            @error('slug')

                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

            <p class="text-xs text-gray-500 mt-1">
                Example: users.view, students.create, fees.edit
            </p>

        </div>


        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Module
            </label>

            <input
                type="text"
                name="module"
                value="{{ old('module', $permission->module ?? '') }}"
                placeholder="Users"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                required
            >

            @error('module')

                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>


        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>

            <textarea
                name="description"
                rows="4"
                placeholder="Describe what this permission allows."
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            >{{ old('description', $permission->description ?? '') }}</textarea>

            @error('description')

                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>

    </div>


    <div class="flex justify-end gap-3 mt-6 pt-5 border-t">

        <a
            href="{{ route('admin.permissions.index') }}"
            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
            Cancel
        </a>

        <button
            type="submit"
            class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">

            {{ isset($permission) ? 'Update Permission' : 'Create Permission' }}

        </button>

    </div>

</div>