<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow rounded-lg p-6 max-w-7xl mx-auto">
            <h3 class="text-3xl font-bold text-white mb-6">{{ __('Welcome back') }}, {{ Auth::user()->name }}!</h3>
            <p class="text-white">You are logged in!</p>

            {{-- Search and Filter --}}
            <div class="flex items-center justify-between py-4">
                {{-- Search Input --}}
                <form action="{{ route('dashboard') }}" method="get" class="flex flex-items justify-center w-1/4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..."
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 border border-gray-700 text-white px-4 py-2 rounded-r-lg">Search</button>
                    @if (request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    @if (request('search'))
                        <a href="{{ route('dashboard', ['type' => request('type')]) }}"
                            class="ml-2 text-white px-4 py-2 rounded-lg">Clear</a>
                    @endif
                </form>

                {{-- Filter Dropdown --}}
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard', ['type' => 'full-time', 'search' => request('search')]) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Fulltime</a>
                    <a href="{{ route('dashboard', ['type' => 'remote', 'search' => request('search')]) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Remote</a>
                    <a href="{{ route('dashboard', ['type' => 'hybrid', 'search' => request('search')]) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Hybrid</a>
                    <a href="{{ route('dashboard', ['type' => 'contract', 'search' => request('search')]) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Contract</a>
                    @if (request('type'))
                        <a href="{{ route('dashboard', ['search' => request('search')]) }}"
                            class="ml-2 text-white px-4 py-2 rounded-lg">Clear</a>
                    @endif

                </div>
            </div>

            {{-- Job Listings --}}
            <div class="space-y-4 mt-8">
                <h4 class="text-xl font-semibold text-white mb-4">Available Jobs</h4>
                @forelse ($jobs as $job)
                    {{-- Job Item --}}
                    <div class="border border-white/10 p-4 flex justify-between items-center">
                        <div>
                            <a class="text-lg font-semibold text-blue-400 hover:underline"> {{ $job->title }} </a>
                            <p class="text-sm text-white/70"> {{ $job->company->name }} • {{ $job->location }}</p>
                            <p class="text-sm text-white/70"> {{ '$' . number_format($job->salary) }} / year</p>
                        </div>
                        <span class="bg-blue-500 text-white p-2 rounded-lg">{{ $job->type }}</span>
                    </div>
                @empty
                    <p class="text-white font-bold text-2xl">No jobs found.</p>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
