<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-indigo-800 tracking-wide">
            {{ __('🎤 Event Feedback') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4">

            <!-- Feedback Prompt -->
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">📝 Write Feedback for Past Events</h1>

            @php
                $writeFeedbackEvents = $events->filter(function ($event) {
                    return \Carbon\Carbon::parse($event->date)->isPast() && $event->feedbacks->isEmpty();
                });
            @endphp

            @forelse ($writeFeedbackEvents as $event)
                <div class="bg-white border-l-4 border-blue-500 shadow-md rounded-xl p-6 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h3 class="text-lg font-bold text-blue-800 uppercase">{{ $event->program_name }}</h3>
                            <span class="text-sm text-black-500 uppercase">{{ $event->club_name }}</span>
                        </div>
                        <a href="{{ route('feedback.create', ['event' => $event->id]) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-full transition">
                            ✏️ Write Feedback
                        </a>
                    </div>
                    <div class="text-sm text-black-700 space-y-1 mt-2">
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                        <p><strong>Location:</strong> {{ $event->location }}</p>
                        <p><strong>Fee:</strong> RM {{ $event->fee }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 mb-10 italic">You have no events pending feedback submission.</p>
            @endforelse

            <!-- Submitted Feedback Section -->
            <h1 class="text-2xl font-semibold text-black-800 mt-12 mb-6">✅ Submitted Feedback</h1>

            @php
                $submittedFeedbackEvents = $events->filter(function ($event) {
                    return \Carbon\Carbon::parse($event->date)->isPast() && !$event->feedbacks->isEmpty();
                });
            @endphp

            @forelse ($submittedFeedbackEvents as $event)
                <div class="bg-green-50 border-l-4 border-green-600 shadow-md rounded-xl p-6 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h3 class="text-lg font-bold text-green-700 uppercase">{{ $event->program_name }}</h3>
                            <span class="text-sm text-black-500 uppercase">{{ $event->club_name }}</span>
                        </div>
                        <div class="text-sm text-green-700 font-semibold">✔ Feedback Submitted</div>
                    </div>
                    <div class="text-sm text-gray-700 space-y-1 mt-2">
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                        <p><strong>Location:</strong> {{ $event->location }}</p>
                        <p><strong>Fee:</strong> RM {{ $event->fee }}</p>
                    </div>
                   <div class="mt-3 flex items-center space-x-2">
                        <strong class="text-sm text-gray-600">Rating:</strong>
                        @php
                            $rating = $event->feedbacks->first()->rating ?? 0;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $rating)
                                <span class="text-yellow-600 text-xl">&#9733;</span>  {{-- darker yellow filled star --}}
                            @else
                                <span class="text-yellow-300 text-xl">&#9733;</span>  {{-- lighter yellow empty star --}}
                            @endif
                        @endfor
                    </div>

                </div>
            @empty
                <p class="text-gray-600 italic">You haven't submitted any feedback yet.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>
