<x-app-layout>

    @if (session('success'))
        <div class="w-full bg-indigo-600 text-white p-4 mb-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif


    <div class="py-12">
        <div class="bg-black shadow rounded-lg p-6 max-w-7xl mx-auto space-y-5">
            @forelse ($jobApplications as $jobApplication)
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h3 class="text-2xl font-semibold text-white mb-2">{{ $jobApplication->jobVacancy->title }}</h3>
                    <p class="text-white/70 mb-1"><strong>Company:</strong>
                        {{ $jobApplication->jobVacancy->company->name }}</p>
                    <p class="text-white/70 mb-1"><strong>Location:</strong>
                        {{ $jobApplication->jobVacancy->location }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <p class="text-sm"><strong>Applied on:</strong>
                            {{ $jobApplication->created_at->format('M d, Y') }}</p>
                        <p class="px-3 py-1 bg-blue-600 text-white rounded-md"> {{ $jobApplication->jobVacancy->type }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span> Applied with: {{ $jobApplication->resume->filename }}</span>
                        <a href="{{ Storage::disk('cloud')->url($jobApplication->resume->fileUri) }}" target="_blank"
                            class="text-indigo-500 hover:text-indigo-600">View Resume</a>
                    </div>

                    <div class="flex flex-start flex-col gap-2">

                        <div>
                            @php
                                $status = $jobApplication->status;

                                $statusClass = match ($status) {
                                    'pending' => 'bg-yellow-500',
                                    'reviewed' => 'bg-indigo-600',
                                    'accepted' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                    default => 'bg-gray-500',
                                };
                            @endphp

                            <p class="text-sm {{ $statusClass }} text-white p-2 rounded-md w-fit">
                                <strong>Status:</strong> {{ ucfirst($status) }}
                            </p>
                            <p class="text-sm bg-indigo-600 text-white p-2 rounded-md w-fit mt-2">
                                <strong>Score:</strong> {{ $jobApplication->aiGeneratedScore ?? 'N/A' }}
                            </p>
                            <p class="text-sm">AI Feedback: {{ $jobApplication->aiGeneratedFeedback ?? 'N/A' }}</p>
                        </div>

                    </div>
                </div>
            @empty
                <p class="text-white font-bold text-2xl">You have not applied to any jobs yet.</p>
            @endforelse
        </div>

        <div>
            {{ $jobApplications->links() }} </div>
    </div>
</x-app-layout>
