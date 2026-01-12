@php
    $isJobsTab = request('tab') == 'jobs' || request('tab') == null;
    $isApplicantionsTab = request('tab') == 'applicantions';
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">

            {{-- Company Details --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">
                    Company Information
                </h3>
                <p>
                    <strong>Owner:</strong> {{ $company->owner->name }}
                </p>
                <p>
                    <strong>Address:</strong> {{ $company->address }}
                </p>
                <p>
                    <strong>Email:</strong> {{ $company->owner->email }}
                </p>
                <p>
                    <strong>Industry:</strong> {{ $company->industry }}
                </p>
                <p>
                    <strong>Website:</strong> <a href="{{ $company->website }}" target="_blank"
                        class="text-blue-500 hover:text-blue-700 underline"> {{ $company->website }}
                    </a>
                </p>
            </div>

            {{-- Company Actions --}}
            <div class="flex justify-end space-x-4 mb-4">
                <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectTo' => 'show']) }}"
                    class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md">
                    Edit</a>
                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline">
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
                        <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                            class="px-4 py-2 text-gray-500 hover:text-gray-600 {{ $isJobsTab ? 'border-b-2 border-blue-500' : '' }}">Jobs</a>
                    </li>
                    <li>
                        <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applicantions']) }}"
                            class="px-4 py-2 text-gray-500 hover:text-gray-600 {{ $isApplicantionsTab ? 'border-b-2 border-blue-500' : '' }}">Applicantions</a>
                    </li>
                </ul>
            </div>

            {{-- Tab Content --}}
            <div>
                {{-- Jobs --}}
                <div id="jobs" class="{{ $isJobsTab ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Title </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Description </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Location </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($company->jobVacancies as $job)
                                <tr>
                                    <td class="px-6 py-4">
                                        {{ $job->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $job->description }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $job->location }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('companies.show', ['company' => $company->id, 'job' => $job->id]) }}"
                                            class="text-blue-600 underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Applicantions --}}
                <div id="applicantions" class="{{ $isApplicantionsTab ? 'block' : 'hidden' }}">
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
                            @foreach ($company->applications as $application)
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
                                        <a href="{{ route('companies.show', ['company' => $company->id, 'application' => $application->id]) }}"
                                            class="text-blue-600 underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
