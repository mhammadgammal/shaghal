    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Job Category') }}
            </h2>
        </x-slot>

        <div class="overflow-x-auto p-6">
            <div class="max-w-2xl mx-auto p-6 bh-white rounded-md shadow-md">
                <form action="{{ route('job-categories.update', $jobCategory->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name"
                            class="{{ $errors->has('name') ? 'border-red-500' : '' }}  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('name', $jobCategory->name) }}">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Edit
                            Category</button>
                        <a href="{{ route('job-categories.index') }}"
                            class="px-4 py-2 rounded-md text-gray-600 hover:text-gray-900">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </x-app-layout>
