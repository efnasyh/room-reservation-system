<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Comments for ') }} {{ $event->program_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-bold text-xl">Comments</h3>

                    <!-- Display Event Comments -->
                    @if ($event->comments->count() > 0)
                        <ul class="list-disc pl-5">
                            @foreach ($event->comments as $comment)
                                <li>{{ $comment->content }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No comments yet.</p>
                    @endif

                    <!-- Add Comment Form -->
                    <div class="mt-4">
                        <form action="{{ route('events.addComment', $event->id) }}" method="POST">
                            @csrf
                            <textarea name="comment" rows="4" class="w-full border-gray-300 rounded-md" placeholder="Add a comment..."></textarea>
                            @error('comment')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md">Add Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
