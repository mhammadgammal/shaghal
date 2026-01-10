<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-md shadow-md">
            <form action="{{ route('job-vacancies.store') }}" method="POST">
                @csrf

                {{-- Job Vacancy details --}}
                <div class="mb-4 p-6 bg-gray-50 border-gray">
                    <div>
                        <h3 class="text-lg font-bold">Job Vacancy Details</h3>
                        <p class="text-sm text-gray-500 mb-4">
                            Enter Job Vacancy details
                        </p>
                    </div>
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title"
                            class="{{ $errors->has('title') ? 'border-red-500' : '' }}  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('title') }}">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location"
                            class="{{ $errors->has('location') ? 'border-red-500' : '' }}  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('location') }}">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                        <input type="text" name="salary" id="salary"
                            class="{{ $errors->has('salary') ? 'border-red-500' : '' }}  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('salary') }}">
                        @error('salary')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type"
                            class="{{ $errors->has('type') ? 'border-red-500' : '' }}  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('type') }}" placeholder="Select Type">
                            @foreach ($jobTypes as $jobType)
                                <option value="{{ $jobType }}">{{ $jobType }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="category_id"
                            class="{{ $errors->has('category_id') ? 'border-red-500' : '' }}  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('category_id') }}" placeholder="Select Category">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="company_id" class="block text-sm font-medium text-gray-700">Company</label>
                        <select name="company_id" id="company_id"
                            class="{{ $errors->has('type') ? 'border-red-500' : '' }}  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('company_id') }}" placeholder="Select Type">
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea type="text" name="description" id="description" rows="4"
                            class="{{ $errors->has('description') ? 'border-red-500' : '' }}  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('description') }}"></textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Add
                            Job Vacancy</button>
                        <a href="{{ route('job-vacancies.index') }}"
                            class="px-4 py-2 rounded-md text-gray-600 hover:text-gray-900">
                            Cancel
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
