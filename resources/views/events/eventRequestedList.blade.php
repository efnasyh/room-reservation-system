<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-indigo-800 leading-tight">
            📑 {{ __('Event Requested List') }}
        </h2>
    </x-slot>

    <!-- Alerts -->
    @if (session('message'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-md shadow mb-4">
            ✅ {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-md shadow mb-4">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                📋 Event Requested List
            </h3>

            @if ($events->isEmpty())
                <div class="bg-white shadow-md rounded-lg p-8 text-center">
                    <p class="text-lg text-gray-500">🚫 No requested events found.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($events as $event)
                        <div x-data="{ open: false }" class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition p-6">

                            <!-- Top Row -->
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">

                                <!-- Program Info -->
                                <div>
                                    <h3 class="text-xl font-bold text-indigo-800">
                                        🎯 {{ $event->program_name }}
                                    </h3>
                                    <p class="text-gray-700 mt-1">
                                        <strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                    </p>
                                    <p><strong>🏛️ Club:</strong> {{ $event->club_name }}</p>
                                </div>

                                <!-- Status Update -->
                                <div class="w-full md:w-auto">
                                    <form action="{{ route('events.updateStatusAndComment', $event->id) }}" method="POST" class="flex flex-col gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="border border-gray-300 rounded-md px-3 py-2 text-gray-800 shadow-sm focus:outline-indigo-500">
                                            <option value="pending" {{ $event->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="approved" {{ $event->status == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                                            <option value="rejected" {{ $event->status == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                        </select>
                                            <button type="submit"
                                                style="background-color:rgb(27, 134, 70); color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; border: none;"
                                                class="shadow-md hover:bg-blue-800 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                🔄 Change Status
                                            </button>

                                    </form>
                                </div>
                            </div>

                            <!-- Toggle Details -->
                            <div class="mt-4 text-center">
                                <button @click="open = !open" class="text-indigo-600 font-semibold hover:text-indigo-800 transition">
                                    <span x-show="!open">🔽 Read More</span>
                                    <span x-show="open">🔼 Hide Details</span>
                                </button>
                            </div>

                            <!-- Expanded Details -->
                            <div x-show="open" x-transition class="mt-6 border-t pt-4 space-y-3 text-gray-800 text-sm leading-relaxed">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
                                    <p><strong>👤 Applicant:</strong> {{ $event->applicant_name }} ({{ $event->matric_no }})</p>
                                    <p><strong>💼 Position:</strong> {{ $event->position }}</p>
                                    <p><strong>📞 Phone:</strong> {{ $event->phone_no }}</p>
                                    <p><strong>👨‍🏫 Advisor:</strong> {{ $event->advisor_name }}</p>
                                    <p><strong>✉️ Email:</strong> {{ $event->email }}</p>
                                    <p><strong>📍 Location:</strong> {{ $event->location }}</p>
                                    <p><strong>💰 Allocation Requested:</strong> RM {{ $event->allocation_requested }}</p>
                                    <p><strong>👥 Participants:</strong> {{ $event->participants }}</p>
                                    <p><strong>🎟️ Fee Per Pax:</strong> RM {{ $event->fee }}</p>
                                </div>

                                <!-- Paperwork -->
                                <div class="pt-3">
                                    @if ($event->paperwork)
                                        <a href="{{ asset('storage/' . $event->paperwork) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-md shadow transition" download>
                                            📥 Download Paperwork
                                        </a>
                                    @else
                                        <p class="text-gray-500 italic">No paperwork uploaded.</p>
                                    @endif
                                </div>

                                <!-- Comment Form -->
                                <div>
                                    <form action="{{ route('events.addComment', $event->id) }}" method="POST" class="space-y-2">
                                        @csrf
                                        <textarea name="comment" rows="2" class="w-full border border-gray-300 rounded-md p-3 focus:outline-indigo-500" placeholder="💬 Add a comment..." required></textarea>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow">
                                            Submit Comment
                                        </button>
                                    </form>
                                </div>

                                <!-- Comment List -->
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-1">🗨️ Comments:</h4>
                                    @if ($event->comments->count() > 0)
                                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                                            @foreach ($event->comments as $comment)
                                                <li>{{ $comment->content }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-sm text-gray-500 italic">No comments yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
