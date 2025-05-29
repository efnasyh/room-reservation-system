<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Requested List') }}
        </h2>
    </x-slot>

    <!-- Session Messages -->
    @if (session('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Check if there are no events -->
            @if ($events->isEmpty())
                <div class="bg-white shadow-md rounded-lg mb-6 p-6 text-center">
                    <p class="text-xl text-gray-600">{{ __('There is no requested event at the moment.') }}</p>
                </div>
            @else
                @foreach ($events as $event)
                    <div class="bg-white shadow-md rounded-lg mb-6 p-6">
                        <div class="flex items-center justify-between">
                            <!-- Event Details -->
                            <div>
                                <h3 class="font-bold text-xl">{{ $event->program_name }}</h3>
                                <p><strong>Applicant Name:</strong> {{ $event->applicant_name }}</p>
                                <p><strong>Matric No:</strong> {{ $event->matric_no }}</p>
                                <p><strong>Position:</strong> {{ $event->position }}</p>
                                <p><strong>Phone No:</strong> {{ $event->phone_no }}</p>
                                <p><strong>Club Name:</strong> {{ $event->club_name }}</p>
                                <p><strong>Advisor Name:</strong> {{ $event->advisor_name }}</p>
                                <p><strong>Email:</strong> {{ $event->email }}</p>
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                                <p><strong>Allocation Requested: RM</strong> {{ $event->allocation_requested }}</p>
                                <p><strong>Participants:</strong> {{ $event->participants }}</p>
                                <p><strong>Fee Per Pax: RM</strong> {{ $event->fee }}</p>
                            </div>

                            <!-- Event Status Dropdown and Change Button -->
                            <div class="text-right">
                                <form action="{{ route('events.updateStatusAndComment', $event->id) }}" method="POST" class="space-y-2">
                                    @csrf
                                    @method('PUT')
                                    <p class="font-bold text-gray-700">Event Status:</p>
                                    <select name="status" class="select w-full max-w-xs mb-2" required>
                                        <option value="pending" {{ $event->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $event->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $event->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">
                                        Change Status
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Download Paperwork Button -->
                        <div class="mt-4">
                            @if ($event->paperwork)
                                <a href="{{ asset('storage/' . $event->paperwork) }}" class="btn btn-primary" download>
                                    Download Paperwork
                                </a>

                            @else
                                <p>No paperwork uploaded.</p>
                            @endif
                        </div>

                        <!-- Add Comment Section -->
                        <div class="mt-4">
                            <form action="{{ route('events.addComment', $event->id) }}" method="POST" class="space-y-2">
                                @csrf
                                <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-md mb-2" placeholder="Add a comment..." required></textarea>
                                <button type="submit" class="btn btn-primary">
                                    Submit Comment
                                </button>
                            </form>
                        </div>

                        <!-- Display Comments -->
                        <div class="mt-4">
                            <h4 class="font-semibold text-lg">Comments:</h4>
                            @if ($event->comments->count() > 0)
                                <ul class="list-disc pl-5">
                                    @foreach ($event->comments as $comment)
                                        <li>{{ $comment->content }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No comments yet.</p>
                            @endif
                        </div>

                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
