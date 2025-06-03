<!-- resources/views/components/sidebar.blade.php -->
<div class="bg-white rounded-2xl shadow p-4 space-y-4 text-sm text-gray-700">

    @if(auth()->user()->role === 'admin')
    <div>
        <h3 class="text-lg font-semibold text-indigo-700 mb-2">🎓 HEP Panel</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('events.eventRequestedList') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📥</span>
                    <span class="ml-3">Event Requested</span>
                </a>
            </li>
             <li>
                <a href="{{ route('event.calendar') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">🗓️</span>
                    <span class="ml-3">Calendar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('events.report') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📊</span>
                    <span class="ml-3">Event Totals</span>
                </a>
            </li>
            <li>
                <a href="{{ route('events.listReport') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📄</span>
                    <span class="ml-3">Event Details</span>
                </a>
            </li>
        </ul>
    </div>
    @endif

    @if(auth()->user()->role === 'mpp')
    <div>
        <h3 class="text-lg font-semibold text-indigo-700 mb-2">🏛️ MPP Panel</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('events.eventRequestedList') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📥</span>
                    <span class="ml-3">Event Requested</span>
                </a>
            </li>
             <li>
                <a href="{{ route('event.calendar') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">🗓️</span>
                    <span class="ml-3">Calendar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('events.report') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📊</span>
                    <span class="ml-3">Event Totals</span>
                </a>
            </li>
            <li>
                <a href="{{ route('events.listReport') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📄</span>
                    <span class="ml-3">Event Details</span>
                </a>
            </li>
        </ul>
    </div>
    @endif

    @if(auth()->user()->role === 'user')
    <div>
        <h3 class="text-lg font-semibold text-indigo-700 mb-2">🎤 Organizer</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('events.create') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📝</span>
                    <span class="ml-3">Apply Event</span>
                </a>
            </li>
            <li>
                <a href="{{ route('events.status') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📌</span>
                    <span class="ml-3">Event Status</span>
                </a>
            </li>
            <li>
                <a href="{{ route('event.calendar') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">🗓️</span>
                    <span class="ml-3">Calendar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('events.userOrganized') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📈</span>
                    <span class="ml-3">Reports & Analysis</span>
                </a>
            </li>
        </ul>
    </div>
    @endif

    @if(auth()->user()->role === 'student')
    <div>
        <h3 class="text-lg font-semibold text-indigo-700 mb-2">🎓 Student</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('events.upcoming') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">📅</span>
                    <span class="ml-3">Upcoming Events</span>
                </a>
            </li>
            <li>
                <a href="{{ route('club_associations.index') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">👥</span>
                    <span class="ml-3">Clubs & Associations</span>
                </a>
            </li>
            <li>
                <a href="{{ route('event.calendar') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">🗓️</span>
                    <span class="ml-3">Calendar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('feedback.index') }}" class="flex items-center p-2 rounded-lg hover:bg-indigo-50 transition">
                    <span class="text-lg">💬</span>
                    <span class="ml-3">Feedback</span>
                </a>
            </li>
        </ul>
    </div>
    @endif

</div>
