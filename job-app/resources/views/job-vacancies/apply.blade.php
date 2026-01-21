<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ $jobVacancy->title }} - apply
        </h2>
    </x-slot>
    <div class="py-12">

        {{-- Back to Jobs button --}}
        <div class="text-white hover:underline hover:text-blue-400  shadow rounded-lg pb-6 max-w-7xl mx-auto">
            <a href="{{ route('dashboard') }}">&larr; Back to Job Details</a>
        </div>

        {{-- Job Details --}}
        <div class="bg-black shadow rounded-lg p-6 max-w-7xl mx-auto">

            <div class="border-b border-white/10 pb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">
                            {{ $jobVacancy->title }}
                        </h1>
                        <p class="text-md text-gray-400">
                            {{ $jobVacancy->company->name }} • {{ $jobVacancy->location }}
                        </p>
                        <p class="text-sm text-gray-400">${{ number_format($jobVacancy->salary) }} .
                            {{ $jobVacancy->type }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('job-vacancies.process-application', ['id' => $jobVacancy->id]) }}" method="POST"
                enctype="multipart/form-data" class="mt-6">
                @csrf

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-red-500">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- resume selection --}}
                <div>
                    <h3 class="text-xl font-semibold text-white">Choose your Resume</h3>

                    <div class="mb-6">
                        <x-input-label for="resume" value="Select from your existing resumes" />
                        {{-- List of resumes --}}
                        @if ($resumes->isEmpty())
                            <p class="text-gray-400">You have no saved resumes.</p>
                        @else
                            <div class="space-y-2">
                                @foreach ($resumes as $resume)
                                    <div class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" name="resume_option" id="{{ $resume->id }}"
                                            value="{{ $resume->id }}" class="form-radio text-blue-600"
                                            @error('resume_option')
                                                class="border-red-500"
                                                @else
                                                class="border-gray-300"
                                            @enderror
                                            {{ old('resume_option') == $resume->id ? 'checked' : '' }}>
                                        <label for="{{ $resume->id }}"
                                            class="text-white">{{ $resume->filename }}</label>
                                        <span class="text-gray-500">
                                            Last Updated: {{ $resume->updated_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Upload new resume --}}

                <div x-data="{ fileName: '', hasError: {{ $errors->has('resume_file') ? 'true' : 'false' }} }" class="mt-6">


                    <div class="mb-6">
                        <div class="flex flex-items space-x-2 mb-2">
                            <input x-ref="newResumeRadio" type="radio" name="resume_option" id="new_resume"
                                value="new_resume" class="form-radio text-blue-600"
                                @error('resume_option')
                                                class="border-red-500"
                                                @else
                                                class="border-gray-300"
                                            @enderror
                                {{ old('resume_option') == 'new_resume' ? 'checked' : '' }}>
                            <x-input-label for="new_resume" value="Or Upload a New Resume (PDF, DOCX)" />
                        </div>
                        <div class="flex items-center">
                            <div class="flex-1">

                                <label for="new_resume_file" class="block text-white cursor-pointer">
                                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-4 hover:border-blue-500 transition"
                                        :class="{ 'border-blue-500': fileName !== '', 'border-red-500': hasError }">

                                        <input
                                            @change="fileName = $event.target.files[0].name; $refs.newResumeRadio.checked = true; hasError = false;"
                                            type="file" name="resume_file" id="new_resume_file" class="hidden"
                                            accept=".pdf" />

                                        <div class="text-center">
                                            <template x-if="fileName === ''">
                                                <p class="text-gray-400">Click to upload your resume PDF (Max 5MB)</p>
                                            </template>
                                            <template x-if="fileName !== ''">
                                                <div>
                                                    <p x-text="fileName" class="text-blue-400"></p>
                                                    <p class="text-gray-400 text-sm mt-1">Click to change file</p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit button --}}
                    <div>
                        <x-primary-button class="w-full">Apply</x-primary-button>
                    </div>
            </form>
        </div>
</x-app-layout>
