@php
    $isArchived = request()->has('archived') && request()->input('archived') == true;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($isArchived ? 'Archived Companies' : 'Companies') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast-notification />

        <div class="flex justify-end mb-4">

            <div class="flex justify-between items-center">
                <div>

                    @if ($isArchived)
                        <a href="{{ route('companies.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Active</a>
                    @else
                        <!-- Archive -->
                        <a href="{{ route('companies.index', ['archived' => true]) }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Arichived</a>
                    @endif




                    <!-- add company button -->
                    <a href="{{ route('companies.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        Add Company
                    </a>
                </div>
            </div>

        </div>
        <!-- company table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Address</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Industry</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Website</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            <a href="{{ route('companies.show', $company->id) }}" class="text-blue-500 hover:text-blue-700 underline"> {{ $company->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $company->address }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $company->industry }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $company->website }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            @if ($isArchived)
                                <form action="{{ route('companies.restore', $company->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success text-green-500">♻️ Restore</button>
                                </form>
                            @else
                                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">✍️
                                    Edit</a>
                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
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
                        <td colspan="2" class="text-center py-4">No companies found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $companies->links() }}
        </div>
    </div>
</x-app-layout>
