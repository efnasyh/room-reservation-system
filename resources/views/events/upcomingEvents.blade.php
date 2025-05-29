<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-indigo-800 tracking-tight">
            {{ __('🎉 Upcoming Events') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-white to-blue-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Flash Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-900 rounded shadow">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Upcoming Events Section -->
            <h2 class="text-2xl font-semibold text-blue-700 mb-6">📅 List of Upcoming Events</h2>

            @if ($events->count() > 0)
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach ($events as $event)
                        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-md hover:shadow-lg transition duration-300">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 uppercase">{{ $event->program_name }}</h3>
                                    <span class="inline-block mt-1 text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded-full uppercase tracking-wide font-semibold">
                                        {{ $event->club_name }}
                                    </span>
                                </div>
                                <div class="text-right text-sm text-gray-600">
                                    <p><strong>Date:</strong><br>{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <div class="text-sm text-gray-700 space-y-1">
                                <p><strong>📍 Location:</strong> {{ $event->location }}</p>
                                <p><strong>💰 Fee:</strong> RM {{ number_format($event->fee, 2) }}</p>
                            </div>

                            <div class="mt-4">
                                @php $isRegistered = $registeredEvents->contains('event_id', $event->id); @endphp
                                @if ($isRegistered)
                                    <span class="inline-block bg-green-600 text-white text-sm font-bold px-4 py-2 rounded-full">
                                        REGISTERED ✔
                                    </span>
                                @else
                                    <a href="{{ route('events.register', ['id' => $event->id]) }}"
                                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-full transition">
                                        JOIN NOW
                                        </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 mt-6 text-center italic">No upcoming events are available at the moment.</p>
            @endif
<div class="mt-6"></div>
            <!-- Registered Events Section -->
            @if ($registeredEvents->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-semibold text-green-700 mb-4">✅ Event(s) You’ve Registered</h2>

                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach ($registeredEvents as $reg)
                            <div class="bg-green-100 border border-green-400 p-4 rounded-xl shadow-sm">
                                <h4 class="font-bold text-green-900">{{ $reg->event->program_name }}</h4>
                                <p class="text-sm text-green-800">📆 {{ \Carbon\Carbon::parse($reg->event->date)->format('d/m/Y') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
