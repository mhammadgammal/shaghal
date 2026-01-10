@php
    $isArchived = request()->has('archived') && request()->input('archived') == true;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($isArchived ? 'Archived Jobs Applications' : 'Jobs Applications') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast-notification />

        <div class="flex justify-end mb-4">

            <div class="flex justify-between items-center">
                <div>

                    @if ($isArchived)
                        <a href="{{ route('job-applications.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Active</a>
                    @else
                        <!-- Archive -->
                        <a href="{{ route('job-applications.index', ['archived' => true]) }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Arichived</a>
                    @endif
                </div>
            </div>

        </div>
        <!-- vacancies table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Applicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Position (Job Vacancy) </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                    <tr class="border-b">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            @if ($isArchived)
                                <span class="text-gray-500">{{ $application->user->name }}</span>
                            @else
                                <a href="{{ route('job-applications.show', $application->id) }}"
                                    class="text-blue-500 hover:text-blue-700 underline"> {{ $application->user->name }}
                                </a>
                            @endIf
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $application->jobVacancy->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $application->jobVacancy->company->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                            <span
                                class="@if ($application->status == 'accepted') text-green-500 @elseif ($application->status == 'rejected') text-red-500 @else  text-gray-500 @endif">
                                {{ $application->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            @if ($isArchived)
                                <form action="{{ route('job-applications.restore', $application->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success text-green-500">♻️ Restore</button>
                                </form>
                            @else
                                <a href="{{ route('job-applications.edit', ['job_application' => $application->id, 'redirectTo' => 'list']) }}"
                                    class="btn btn-primary">✍️
                                    Edit</a>
                                <form action="{{ route('job-applications.destroy', $application->id) }}" method="POST"
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
                        <td colspan="2" class="text-center py-4">No Applications found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $applications->links() }}
        </div>
    </div>
</x-app-layout>
