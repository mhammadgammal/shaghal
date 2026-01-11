<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-6">
        {{-- Overview cards --}}
        <div class="grid grid-cols-3 gap-6">
            {{-- Active Users --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Active Users') }}</h3>
                    <p class="text-3xl font-bold text-indigo-600">100</p>
                    <p class="text-sm text-gray-500"> Last 30 days </p>
                </div>
            </div>
            {{-- Total Jobs --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Total Jobs') }}</h3>
                    <p class="text-3xl font-bold text-indigo-600">100</p>
                    <p class="text-sm text-gray-500"> All Time </p>
                </div>
            </div>
            {{-- Total Application --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Total Application') }}</h3>
                    <p class="text-3xl font-bold text-indigo-600">100</p>
                    <p class="text-sm text-gray-500"> All Time </p>
                </div>
            </div>
        </div>
    </div>
    {{-- most Applied Jobs --}}
    <div class="grid grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Most Applied Jobs') }}</h3>
        </div>
    </div>
    {{-- Conversion Rates --}}

    </div>
</x-app-layout>
