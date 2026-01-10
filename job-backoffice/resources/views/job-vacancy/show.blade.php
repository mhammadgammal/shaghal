<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $vacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">

            {{-- Job Vacancy Details --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">
                    Job Vacancy Information
                </h3>
                <p>
                    <strong>Company:</strong> {{ $vacancy->company->name }}
                </p>
                <p>
                    <strong>Address:</strong> {{ $vacancy->location }}
                </p>
                <p>
                    <strong>Type:</strong> {{ $vacancy->type }}
                </p>
                <p>
                    <strong>Salary:</strong> {{ $vacancy->salary }}
                </p>
                <p>
                    <strong>Description:</strong> {{ $vacancy->description }}
                </p>
            </div>

            {{-- Vacancy Actions --}}
            <div class="flex justify-end space-x-4 mb-4">
                <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $vacancy->id, 'redirectTo' => 'show']) }}"
                    class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md">
                    Edit</a>
                <form action="{{ route('job-vacancies.destroy', $vacancy->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn btn-danger bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-md">Archive</button>
                </form>
            </div>

            {{-- Tabs Navigation --}}
            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('job-vacancies.show', ['job_vacancy' => $vacancy->id]) }}"
                            class="px-4 py-2 text-gray-500 hover:text-gray-600 'border-b-2 border-blue-500'">Applicantions</a>
                    </li>
                </ul>
            </div>

            {{-- Tab Content --}}
            <div>

                {{-- Applicantions --}}
                <div id="applicantions" class="block">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Applicant Name
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Job Title </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Status </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vacancy->jobApplications as $application)
                                <tr>
                                    <td class="px-6 py-4">
                                        {{ $application->user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $application->jobVacancy->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $application->status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('job-vacancies.show', ['job_vacancy' => $vacancy->id, 'application' => $application->id]) }}"
                                            class="text-blue-600 underline">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
