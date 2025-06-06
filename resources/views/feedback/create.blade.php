<style>
    input[type="radio"]:checked ~ label {
        color: #facc15; /* yellow-400 */
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-black">
            FEEDBACK
        </h2>
    </x-slot>

<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('feedback.index') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold shadow-md transition duration-200 no-underline">
        ← Back
    </a>
</div>
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                           📝 Feedback Form for {{ $event->program_name }} Program
                        </h3>
</div>
    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="border-2 border-black rounded-xl p-6 bg-white shadow-lg">
                <!-- Event Info -->
                <div class="mb-6">
                    <h3 class="text-xl font-extrabold mb-2">{{ strtoupper($event->program_name) }}</h3>
                    <p><strong>DATE:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>
                    <p><strong>LOCATION</strong> {{ $event->location }}</p>
                    <p><strong>FEE: RM</strong> {{ $event->fee }}</p>
                </div>
                <form action="{{ route('feedback.store', $event->id) }}" method="POST">
                    @csrf
                    @php
                        $scaleLabels = ['1', '2', '3', '4', '5'];
                    @endphp
                    <!-- Event Content -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">The event content was relevant and informative.</label>
                        <div class="flex justify-between text-sm text-gray-600 mb-1 px-2">
                            @foreach ($scaleLabels as $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                        <div class="flex justify-between">
                            @foreach ($scaleLabels as $value)
                                <label>
                                    <input type="radio" name="content_relevance" value="{{ $value }}" required>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <!-- Speaker Quality -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">The speaker(s) were engaging and informative.</label>
                        <div class="flex justify-between text-sm text-gray-600 mb-1 px-2">
                            @foreach ($scaleLabels as $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                        <div class="flex justify-between">
                            @foreach ($scaleLabels as $value)
                                <label>
                                    <input type="radio" name="speaker_quality" value="{{ $value }}" required>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <!-- Event Organization -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">The event was well-organized.</label>
                        <div class="flex justify-between text-sm text-gray-600 mb-1 px-2">
                            @foreach ($scaleLabels as $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                        <div class="flex justify-between">
                            @foreach ($scaleLabels as $value)
                                <label>
                                    <input type="radio" name="organization" value="{{ $value }}" required>
                                </label>
                            @endforeach
                        </div>
                    </div>
<div class="mt-6"></div>
                     <!-- What did you enjoy the most -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">What did you enjoy the most about the event?</label>
                        <input type="text" name="feedback_comments" class="w-full border-2 rounded-full px-4 py-2" required>
                    </div>
                    <!-- Improvement Suggestions -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">What improvement would you suggest for next time?</label>
                        <input type="text" name="improvement_suggestions" class="w-full border-2 rounded-full px-4 py-2">
                    </div>
                    <!-- Overall Rating (Star) -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">Overall Star Rating:</label>
                        <div class="flex flex-row-reverse justify-start space-x-reverse space-x-2">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required />
                                <label for="star{{ $i }}" class="text-3xl text-gray-400 cursor-pointer hover:text-yellow-400">&#9733;</label>
                            @endfor
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-200">
                            Submit Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
