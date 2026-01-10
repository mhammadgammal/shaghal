@php
    $isResume = request()->input('tab') == 'resume' || request()->input('tab') == null;
    $isAiFeedback = request()->input('tab') == 'ai-feedback';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $application->user->name }} | Applied to {{ $application->jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">

            {{-- Job Application Details --}}
            <div>
                <h3 class="text-lg font-semibold mb-4">
                    Application Details
                </h3>
                <p>
                    <strong>Applicant:</strong> {{ $application->user->name }}
                </p>
                <p>
                    <strong>job Vacancy:</strong> {{ $application->jobVacancy->title }}
                </p>
                <p>
                    <strong>Company:</strong> {{ $application->jobVacancy->company->name }}
                </p>
                <p>
                    <strong>Status:</strong> {{ $application->status }}
                </p>
                <p>
                    <strong>Resume:</strong> <a href="{{ $application->resume->fileUri }}"
                        class="text-blue-600 underline">{{ $application->resume->fileUri }}</a>
                </p>
            </div>

            {{-- Application Actions --}}
            <div class="flex justify-end space-x-4 mb-4">
                <form action="{{ route('job-applications.destroy', $application->id) }}" method="POST" class="d-inline">
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
                        <a href="{{ route('job-applications.show', ['job_application' => $application->id, 'tab' => 'resume']) }}"
                            class="px-4 py-2 text-gray-500 hover:text-gray-600 'border-b-2 border-blue-500' {{ $isResume ? 'border-b-2 border-blue-500' : '' }}">Resume</a>
                    </li>
                    <li>
                        <a href="{{ route('job-applications.show', ['job_application' => $application->id, 'tab' => 'ai-feedback']) }}"
                            class="px-4 py-2 text-gray-500 hover:text-gray-600 'border-b-2 border-blue-500' {{ $isAiFeedback ? 'border-b-2 border-blue-500' : '' }}">Ai
                            Feedback</a>
                    </li>
                </ul>
            </div>

            {{-- Tab Content --}}
            <div>

                {{-- Applicantions --}}
                <div id="applicantions" class="block">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            @if ($isResume)
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Summary
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Skills </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Experience
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Education </th>
                                </tr>
                            @endif
                            @if ($isAiFeedback)
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Score </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Feedback </th>
                                </tr>
                            @endif

                        </thead>
                        <tbody>
                            @if ($isResume)
                                <tr>
                                    <td class="px-6 py-4">
                                        {{ $application->resume->summary }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $application->resume->skills }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $application->resume->experience }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $application->resume->education }}
                                    </td>
                                </tr>
                            @endif

                            @if ($isAiFeedback)
                                <tr>
                                    <td class="px-6 py-4">
                                        {{ $application->aiGeneratedScore }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $application->aiGeneratedFeedback }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="flex justify-start space-x-4 mt-10">
            <form
                action="{{ route('job-applications.update', ['job_application' => $application->id, 'status' => 'accepted']) }}"
                method="POST" class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md">
                @csrf
                @method('PUT')
                <button type="submit">
                    Accept</button>
            </form>
            <form
                action="{{ route('job-applications.update', ['job_application' => $application->id, 'status' => 'rejected']) }}"
                method="POST" class="btn btn-danger bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-md">
                @csrf
                @method('PUT')
                <button type="submit">
                    Reject</button>
            </form>
        </div>
    </div>
</x-app-layout>
