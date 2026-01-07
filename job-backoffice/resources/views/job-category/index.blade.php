<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Category') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <div class="absolute inset-x-0 bottom-0 z-50 max-w-2xl">
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-500 text-white px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="flex justify-end mb-4">
            <!-- add category button -->
            <a href="{{ route('job-categories.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                Add Category
            </a>
        </div>
        <!-- job category table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"> {{ $category->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            <a href="{{ route('job-categories.edit', $category->id) }}" class="btn btn-primary">✍️
                                Edit</a>
                            <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-red-500">🗃️ Archive</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
