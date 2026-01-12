@php
    $isArchived = request()->has('archived') && request()->input('archived') == true;
    $isAdmin = auth()->guard()->user()->role === 'admin';
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($isArchived ? 'Archived Jobs' : 'Jobs') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast-notification />

        <div class="flex justify-end mb-4">

            <div class="flex justify-between items-center">
                <div>

                    @if ($isArchived)
                        <a href="{{ route('job-vacancies.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Active</a>
                    @else
                        <!-- Archive -->
                        <a href="{{ route('job-vacancies.index', ['archived' => true]) }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Arichived</a>
                    @endif

                    <!-- add Vacancy button -->
                    <a href="{{ route('job-vacancies.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                        Add Vacancy
                    </a>
                </div>
            </div>

        </div>
        <!-- vacancies table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Title</th>
                    @if ($isAdmin)
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Company </th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vacancies as $vacancy)
                    <tr class="border-b">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            @if ($isArchived)
                                <span class="text-gray-500">{{ $vacancy->title }}</span>
                            @else
                                <a href="{{ route('job-vacancies.show', $vacancy->id) }}"
                                    class="text-blue-500 hover:text-blue-700 underline"> {{ $vacancy->title }}
                                </a>
                            @endIf
                        </td>
                        @if ($isAdmin)
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $vacancy->company->name }}
                            </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $vacancy->location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $vacancy->type }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            ${{ number_format($vacancy->salary) }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            @if ($isArchived)
                                <form action="{{ route('job-vacancies.restore', $vacancy->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success text-green-500">♻️ Restore</button>
                                </form>
                            @else
                                <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $vacancy->id, 'redirectTo' => 'list']) }}"
                                    class="btn btn-primary">✍️
                                    Edit</a>
                                <form action="{{ route('job-vacancies.destroy', $vacancy->id) }}" method="POST"
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
                        <td colspan="2" class="text-center py-4">No vacancies found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $vacancies->links() }}
        </div>
    </div>
</x-app-layout>
