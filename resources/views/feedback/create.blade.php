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

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="border-2 border-black rounded-xl p-6 bg-white shadow-lg">
                <!-- Event Info -->
                <div class="mb-6">
                    <h3 class="text-xl font-extrabold mb-2">{{ strtoupper($event->program_name) }}</h3>
                    <p><strong>DATE:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>
                    <p><strong>FEE: RM</strong> {{ $event->fee }}</p>
                </div>

                <form action="{{ route('feedback.store', $event->id) }}" method="POST">
                    @csrf

                    <!-- Networking Question -->
                    <!-- <div class="mb-6">
                        <label class="block font-bold mb-2">Did you find valuable networking opportunities at the event?</label>
                        <div class="flex items-center gap-6">
                            <label class="inline-flex items-center font-semibold">
                                <input type="radio" name="networking" value="yes" class="mr-2" required> Yes
                            </label>
                            <label class="inline-flex items-center font-semibold">
                                <input type="radio" name="networking" value="no" class="mr-2"> No
                            </label>
                        </div>
                    </div> -->

                    <!-- Enjoyed Most -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">What did you enjoy the most of the event?</label>
                        <input type="text" name="feedback_comments" class="w-full border-2 rounded-full px-4 py-2" required>
                    </div>

                    <!-- Suggestions -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">What improvement would you suggest for next time?</label>
                        <input type="text" name="improvement_suggestions" class="w-full border-2 rounded-full px-4 py-2">
                    </div>

                    <!-- Star Rating -->
                    <div class="mb-6">
                        <label class="block font-bold mb-2">Overall Rating:</label>
                        <div class="flex flex-row-reverse justify-start space-x-reverse space-x-2">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required />
                                <label for="star{{ $i }}" class="text-3xl text-gray-400 cursor-pointer hover:text-yellow-400">&#9733;</label>
                            @endfor
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-right">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
