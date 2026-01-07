@php
    $isArchived = request()->has('archived') && request()->input('archived') == true;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($isArchived ? 'Archived Job Categories' : 'Job Category') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast-notification />

        <div class="flex justify-end mb-4">

            <div class="flex justify-between items-center">
                <div>

                    @if ($isArchived)
                        <a href="{{ route('job-categories.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Active</a>
                    @else
                        <!-- Archive -->
                        <a href="{{ route('job-categories.index', ['archived' => true]) }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Arichived</a>
                    @endif




                    <!-- add category button -->
                    <a href="{{ route('job-categories.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        Add Category
                    </a>
                </div>
            </div>

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
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"> {{ $category->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            @if ($isArchived)
                                <form action="{{ route('job-categories.restore', $category->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success text-green-500">♻️ Restore</button>
                                </form>
                            @else
                                <a href="{{ route('job-categories.edit', $category->id) }}" class="btn btn-primary">✍️
                                    Edit</a>
                                <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-red-500">🗃️ Archive</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-4">No job categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
