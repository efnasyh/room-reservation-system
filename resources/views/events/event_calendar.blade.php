<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="font-bold text-2xl mb-4 text-center">Event Calendar</h3>
                <!-- Calendar Container -->
                <div id="calendar"></div>
            </div>
        </div>
    </div>

  <!-- List of Approved Upcoming Events -->
<div class="bg-white shadow-md rounded-lg mb-6 p-6">
    <h3 class="font-bold text-2xl mb-4 text-black">List of Upcoming Events</h3>
    <ul class="list-disc pl-6">
        @foreach ($events->where('status', 'approved')->filter(function ($event) {
            return \Carbon\Carbon::parse($event->date)->isToday() || \Carbon\Carbon::parse($event->date)->isFuture();
        }) as $event)
            <li class="text-green-600"> <!-- Make entire event text green -->
                <strong>{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}:</strong> 
                {{ $event->program_name }} 
                <span class="text-green-600">by {{ $event->club_name }}</span>
            </li>
        @endforeach
    </ul>
</div>




    <!-- Include FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                events: [
                    @foreach ($events as $event)
                        {
                            title: '{{ $event->program_name }}',
                            start: '{{ $event->date }}',
                            color: "{{ \Carbon\Carbon::parse($event->date)->lt(\Carbon\Carbon::today()) ? '#6c757d' : '#28a745' }}"
                        }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ],
                dateClick: function (info) {
                    alert('Date: ' + info.dateStr);
                }
            });

            calendar.render();
        });
    </script>
</x-app-layout>
