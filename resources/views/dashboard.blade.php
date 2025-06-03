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

                        // Pending events globally (used for admin/mpp)
                        $pending = \App\Models\Event::where('status', 'pending')->count();

                        if ($role === 'mpp' || $role === 'admin') {
                            $upcoming = \App\Models\Event::where('date', '>=', now())->count();
                            $approved = \App\Models\Event::where('status', 'approved')->count();
                            $rejected = \App\Models\Event::where('status', 'rejected')->count();
                        }

                        if ($role === 'user') {
                            // For organizer role: events created by their club/user
                            $clubEventsTotal = \App\Models\Event::where('user_id', $userId)->count();
                            $clubEventsPending = \App\Models\Event::where('user_id', $userId)->where('status', 'pending')->count();
                        }
                    @endphp

                    @if ($role === 'student')
                        <div class="mt-6 p-6 bg-blue-100 rounded-xl shadow text-blue-800">
                            <h3 class="text-xl font-bold mb-1">🎓 Welcome, Student!</h3>
                            <p>You can now explore events, register, and provide feedback.</p>
                        </div>

                    @elseif ($role === 'user')
                        <div class="mt-6 p-6 bg-green-100 rounded-xl shadow text-green-800">
                            <h3 class="text-xl font-bold mb-1">🧑‍💼 Welcome, Organizer!</h3>
                            <p>You can now create events, manage participants, and review feedback.</p>
</div>
                            <!-- Organizer Counters -->
                            <div class="mt-6 overflow-x-auto">
                                <div class="flex gap-6 min-w-[480px]">
                                    <div class="flex-1 min-w-[240px] p-6 bg-blue-100 text-blue-800 rounded-xl shadow hover:shadow-lg transform hover:scale-105 transition text-center">
                                        <div class="text-4xl font-extrabold">{{ $clubEventsTotal }}</div>
                                        <div class="mt-2 text-base font-medium">📊 Total Events Created</div>
                                    </div>

                                    <div class="flex-1 min-w-[240px] p-6 bg-yellow-100 text-yellow-800 rounded-xl shadow hover:shadow-lg transform hover:scale-105 transition text-center">
                                        <div class="text-4xl font-extrabold">{{ $clubEventsPending }}</div>
                                        <div class="mt-2 text-base font-medium">⏳ Pending Events</div>
                                    </div>
                                </div>
                            </div>
                        

                    @elseif ($role === 'mpp' || $role === 'admin')
                        <div class="mt-6 p-6 bg-{{ $role === 'mpp' ? 'purple' : 'yellow' }}-100 rounded-xl shadow text-{{ $role === 'mpp' ? 'purple' : 'yellow' }}-800">
                            <h3 class="text-xl font-bold mb-1">
                                👋 Welcome, {{ $role === 'mpp' ? 'MPP' : 'HEP' }}!
                            </h3>
                            <p>You can now oversee applications, approve events, and manage student requests.</p>

                            <!-- Admin/Mpp Counters -->
                            <div class="mt-6 overflow-x-auto">
                                <div class="flex gap-6 min-w-[768px]">
                                    <div class="flex-1 min-w-[240px] p-6 rounded-xl shadow hover:shadow-lg transform hover:scale-105 transition text-center" style="background-color: #fef9c3; color:rgb(0, 0, 0);">
                                        <div class="text-4xl font-extrabold">{{ $pending }}</div>
                                        <div class="mt-2 text-base font-medium">⏳ Pending Events</div>
                                    </div>

                                    <div class="flex-1 min-w-[240px] bg-blue-100 text-blue-800 p-6 rounded-xl shadow hover:shadow-lg transform hover:scale-105 transition text-center">
                                        <div class="text-4xl font-extrabold">{{ $upcoming }}</div>
                                        <div class="mt-2 text-base font-medium">📅 Upcoming Events</div>
                                    </div>
                                    <div class="flex-1 min-w-[240px] bg-green-100 text-green-800 p-6 rounded-xl shadow hover:shadow-lg transform hover:scale-105 transition text-center">
                                        <div class="text-4xl font-extrabold">{{ $approved }}</div>
                                        <div class="mt-2 text-base font-medium">✅ Approved Events</div>
                                    </div>
                                    <div class="flex-1 min-w-[240px] bg-red-100 text-red-800 p-6 rounded-xl shadow hover:shadow-lg transform hover:scale-105 transition text-center">
                                        <div class="text-4xl font-extrabold">{{ $rejected }}</div>
                                        <div class="mt-2 text-base font-medium">❌ Rejected Events</div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
