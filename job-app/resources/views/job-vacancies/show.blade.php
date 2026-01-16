<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>
    <div class="py-12">

        {{-- Back to Jobs button --}}
        <div class="text-white hover:underline hover:text-blue-400  shadow rounded-lg pb-6 max-w-7xl mx-auto">
            <a href="{{ route('dashboard') }}">&larr; Back to Jobs</a>
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
                    <div class="flex items-center justify-end">
                        <a class="justify-center bg-gradient-to-r from-indigo-500 to-rose-500 text-white px-4 py-2 rounded-lg transition hover:from-indigo-600 hover:to-rose-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ $jobVacancy->application_link }}" target="_blank" rel="noopener noreferrer">
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col gap-4 mt-6">
                <div class="col-span-2">
                    <h2 class="text=lg font-bold text-white"> {{ _('Job Description') }}</h2>
                    <p class="text-gray-400">{{ $jobVacancy->description }}</p>
                </div>
                <div class=" col-span-1">
                    <h2 class="text=lg font-bold text-white"> {{ _('Job Overview') }}</h2>
                    <div class="bg-gray-900 rounded-lg p-6 space-y-4 MT-4">
                        {{-- published At --}}
                        <div class="flex flex-col">
                            <p class="text-gray-500"> Published At </p>
                            <p class="text-white"> {{ $jobVacancy->created_at->format('M d, Y') }} </p>
                        </div>
                        {{-- Company --}}
                        <div class="flex flex-col">
                            <p class="text-gray-500"> company </p>
                            <p class="text-white"> {{ $jobVacancy->company->name }} </p>
                        </div>

                        {{-- Location --}}
                        <div class="flex flex-col">
                            <p class="text-gray-500"> Location </p>
                            <p class="text-white"> {{ $jobVacancy->location }} </p>
                        </div>

                        {{-- Salary --}}
                        <div class="flex flex-col">
                            <p class="text-gray-500"> Salary </p>
                            <p class="text-white"> ${{ number_format($jobVacancy->salary) }} / year </p>
                        </div>

                        {{-- Job Type --}}
                        <div class="flex flex-col">
                            <p class="text-gray-500"> Job Type </p>
                            <p class="text-white"> {{ $jobVacancy->type }} </p>
                        </div>

                        {{-- Category --}}
                        <div class="flex flex-col">
                            <p class="text-gray-500"> Category </p>
                            <p class="text-white"> {{ $jobVacancy->jobCategory->name }} </p>
                        </div>
                    </div>
</x-app-layout>
