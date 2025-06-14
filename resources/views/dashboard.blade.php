<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('UTHM CAMPUS EVENT MANAGEMENT SYSTEM') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    @php
                        $role = auth()->user()->role;
                        $userId = auth()->id();

                        $pending = \App\Models\Event::where('status', 'pending')->count();
                        $upcoming = \App\Models\Event::where('date', '>=', now())->count();
                        $approved = \App\Models\Event::where('status', 'approved')->count();
                        $rejected = \App\Models\Event::where('status', 'rejected')->count();

                        $clubEventsTotal = \App\Models\Event::where('user_id', $userId)->count();
                        $clubEventsPending = \App\Models\Event::where('user_id', $userId)->where('status', 'pending')->count();

                        $registeredEvents = \App\Models\StudentEvent::where('user_id', $userId)->pluck('event_id')->unique();
                        $submittedFeedback = \App\Models\Feedback::where('user_id', $userId)->pluck('event_id')->unique();
                        $notYetFeedback = $registeredEvents->diff($submittedFeedback)->count();
                    @endphp

                    {{-- STUDENT --}}
@if ($role === 'student')
    <div class="mt-6 p-6 bg-blue-100 rounded-xl shadow text-blue-800 text-center">
        <h3 class="text-xl font-bold mb-1">🎓 Welcome, Student!</h3>
        <p>You can now explore events, register, and provide feedback.</p>
    </div>

    <!-- Counter Grid: 2 rows x 2 columns -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6 justify-center max-w-3xl mx-auto">
        <!-- Upcoming Events -->
        <div class="w-full p-6 bg-green-100 text-green-800 rounded-xl shadow text-center">
            <div class="text-4xl font-extrabold">{{ $upcoming }}</div>
            <div class="mt-2 font-medium">📅 Upcoming Events</div>
        </div>

        <!-- Registered Events -->
        <div class="w-full p-6 bg-blue-100 text-blue-800 rounded-xl shadow text-center">
            <div class="text-4xl font-extrabold">{{ $registeredEvents->count() }}</div>
            <div class="mt-2 font-medium">📝 Registered Events</div>
        </div>

        <!-- Feedback Submitted -->
        <div class="w-full p-6 bg-yellow-100 text-yellow-800 rounded-xl shadow text-center">
            <div class="text-4xl font-extrabold">{{ $submittedFeedback->count() }}</div>
            <div class="mt-2 font-medium">⭐ Feedback Submitted</div>
        </div>

        <!-- Feedback Not Submitted -->
        <div class="w-full p-6 bg-red-100 text-red-800 rounded-xl shadow text-center">
            <div class="text-4xl font-extrabold">{{ $notYetFeedback }}</div>
            <div class="mt-2 font-medium">⏳ Feedback Not Submitted</div>
        </div>
    </div>

                    {{-- ORGANIZER --}}
                    @elseif ($role === 'user')
                        <div class="mt-6 p-6 bg-green-100 rounded-xl shadow text-green-800">
                            <h3 class="text-xl font-bold mb-1">🧑‍💼 Welcome, Organizer!</h3>
                            <p>You can now create events, manage participants, and review feedback.</p>
                        </div>

                        <div class="mt-6 flex gap-6 flex-wrap">
                            <div class="flex-1 min-w-[240px] p-6 bg-blue-100 text-blue-800 rounded-xl shadow text-center">
                                <div class="text-4xl font-extrabold">{{ $clubEventsTotal }}</div>
                                <div class="mt-2 font-medium">📊 Total Events Created</div>
                            </div>

                            <div class="flex-1 min-w-[240px] p-6 bg-yellow-100 text-yellow-800 rounded-xl shadow text-center">
                                <div class="text-4xl font-extrabold">{{ $clubEventsPending }}</div>
                                <div class="mt-2 font-medium">⏳ Pending Events</div>
                            </div>
                        </div>

                    {{-- MPP or ADMIN --}}
                    @elseif ($role === 'mpp' || $role === 'admin')
                        <div class="mt-6 p-6 bg-yellow-100 rounded-xl shadow text-yellow-800">
                            <h3 class="text-xl font-bold mb-1">👋 Welcome, {{ strtoupper($role) }}!</h3>
                            <p>You can now oversee applications, approve events, and manage student requests.</p>
                        </div>

                        <div class="mt-6 flex gap-6 flex-wrap">
                            <div class="flex-1 min-w-[240px] p-6 bg-orange-100 text-orange-800 rounded-xl shadow text-center">
                                <div class="text-4xl font-extrabold">{{ $pending }}</div>
                                <div class="mt-2 font-medium">⏳ Pending Events</div>
                            </div>

                            <div class="flex-1 min-w-[240px] p-6 bg-blue-100 text-blue-800 rounded-xl shadow text-center">
                                <div class="text-4xl font-extrabold">{{ $upcoming }}</div>
                                <div class="mt-2 font-medium">📅 Upcoming Events</div>
                            </div>

                            <div class="flex-1 min-w-[240px] p-6 bg-green-100 text-green-800 rounded-xl shadow text-center">
                                <div class="text-4xl font-extrabold">{{ $approved }}</div>
                                <div class="mt-2 font-medium">✅ Approved Events</div>
                            </div>

                            <div class="flex-1 min-w-[240px] p-6 bg-red-100 text-red-800 rounded-xl shadow text-center">
                                <div class="text-4xl font-extrabold">{{ $rejected }}</div>
                                <div class="mt-2 font-medium">❌ Rejected Events</div>
                            </div>
                        </div>

                    {{-- UNKNOWN ROLE --}}
                    @else
                        <div class="mt-6 p-6 bg-red-100 rounded-xl shadow text-red-800">
                            <h3 class="text-xl font-bold mb-1">⚠️ Unknown Role</h3>
                            <p>Please contact the administrator to resolve your account status.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
