<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->program_name }} - Report
        </h2>
    </x-slot>
    <!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('events.userOrganized') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold shadow-md transition duration-200 no-underline">
        ← Back
    </a>
</div>

     <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                            📊 Report Details
            </h3>
            </div>
    <div class="py-6 max-w-6xl mx-auto">
        {{-- Filter Buttons --}}
        <div class="flex justify-center gap-4 mb-6 flex-wrap">
            <a href="{{ route('events.viewReport', ['event' => $event->id, 'filter' => 'all']) }}">
                <button class="px-4 py-2 {{ request('filter', 'all') == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                    All
                </button>
            </a>
            <a href="{{ route('events.viewReport', ['event' => $event->id, 'filter' => 'payments']) }}">
                <button class="px-4 py-2 {{ request('filter') == 'payments' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                    Student Payments
                </button>
            </a>
            <a href="{{ route('events.viewReport', ['event' => $event->id, 'filter' => 'feedback']) }}">
                <button class="px-4 py-2 {{ request('filter') == 'feedback' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                    Feedback
                </button>
            </a>
        </div>

        {{-- Show based on filter --}}
        @php $filter = request('filter', 'all'); @endphp

        @if ($filter === 'payments')
            {{-- Payments Table --}}
            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Student Payments</h3>
                @if ($event->studentRegistrations->count())
                    <table class="table-auto w-full border border-gray-300 mb-6">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-4 py-2">Student Name</th>
                                <th class="border px-4 py-2">Matric No</th>
                                <th class="border px-4 py-2">Faculty</th>
                                <th class="border px-4 py-2">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->studentRegistrations as $registration)
                                <tr>
                                    <td class="border px-4 py-2">{{ $registration->student_name }}</td>
                                    <td class="border px-4 py-2">{{ $registration->matric_no }}</td>
                                    <td class="border px-4 py-2">{{ $registration->faculty }}</td>
                                    <td class="border px-4 py-2">{{ $registration->payment_status ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600">No students have registered for this event.</p>
                @endif
            </div>

        @elseif ($filter === 'feedback')
            {{-- Feedback Table & Bar Chart --}}
                        <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-bold mb-4">Feedback</h3>
                @if ($event->feedbacks->count())
                    <table class="table-auto w-full border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-4 py-2">Student Name</th>
                                <th class="border px-4 py-2">Comment</th>
                                <th class="border px-4 py-2">Suggestions</th>
                                <th class="border px-4 py-2">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->feedbacks as $feedback)
                                @php
                                    $student = $event->studentRegistrations->firstWhere('user_id', $feedback->user_id);
                                @endphp
                                <tr>
                                    <td class="border px-4 py-2">{{ $student->student_name ?? 'Unknown' }}</td>
                                    <td class="border px-4 py-2">{{ $feedback->feedback_comments }}</td>
                                    <td class="border px-4 py-2">{{ $feedback->improvement_suggestions }}</td>
                                    <td class="border px-4 py-2">{{ $feedback->rating }}/5 ⭐️</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Bar Chart --}}
                    <div class="mt-12">
                        <h3 class="text-lg font-bold mb-4 text-center">Feedback Rating Distribution</h3>
                        <div class="max-w-xl mx-auto">
                            <canvas id="feedbackRatingChart" class="w-full h-64"></canvas>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600">No feedback has been submitted yet.</p>
                @endif
            </div>

        @else
            {{-- Combined View --}}
            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">All Report Data</h3>
                @if ($event->studentRegistrations->count() > 0)
                    <table class="table-auto w-full border border-black-300 mb-6">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Student Name</th>
                                <th class="border px-4 py-2">Matric No</th>
                                <th class="border px-4 py-2">Faculty</th>
                                <th class="border px-4 py-2">Payment Status</th>
                                <th class="border px-4 py-2">Comment</th>
                                <th class="border px-4 py-2">Suggestions</th>
                                <th class="border px-4 py-2">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->studentRegistrations as $index => $registration)
                                @php
                                    $feedback = $event->feedbacks->firstWhere('user_id', $registration->user_id);
                                @endphp
                                <tr>
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $registration->student_name }}</td>
                                    <td class="border px-4 py-2">{{ $registration->matric_no }}</td>
                                    <td class="border px-4 py-2">{{ $registration->faculty }}</td>
                                    <td class="border px-4 py-2">{{ $registration->payment_status ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $feedback->feedback_comments ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $feedback->improvement_suggestions ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $feedback->rating ?? '-' }}/5 ⭐️</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

{{-- Charts Side by Side --}}
<div class="mt-12 flex justify-center gap-12 flex-wrap">

    {{-- Feedback Rating Bar Chart --}}
    <div class="max-w-xs w-full">
        <h3 class="text-lg font-bold mb-4 text-center">Feedback Rating Distribution</h3>
        <canvas id="feedbackRatingChart" class="mx-auto" style="max-width: 300px; max-height: 300px;"></canvas>
    </div>

    {{-- Faculty Pie Chart --}}
    <div class="max-w-xs w-full">
        <h3 class="text-lg font-bold mb-4 text-center">Registered Students by Faculty</h3>
        <canvas id="facultyPieChart" class="mx-auto" style="max-width: 300px; max-height: 300px;"></canvas>
    </div>

</div>
                @else
                    <p class="text-gray-600">No student data found for this event.</p>
                @endif
            </div>
        @endif
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if ($event->feedbacks->count())
        {{-- Feedback Rating Chart Script --}}
        <script>
            const allRatings = [1, 2, 3, 4, 5];
            const ratingRaw = @json($event->feedbacks->groupBy('rating')->map->count());
            const ratingLabels = allRatings.map(String);
            const ratingCounts = allRatings.map(r => ratingRaw[r] || 0);

            const ctx = document.getElementById('feedbackRatingChart')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ratingLabels,
                        datasets: [{
                            label: 'Number of Students',
                            data: ratingCounts,
                            backgroundColor: '#3B82F6',
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        aspectRatio: 2,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }
        </script>
    @endif

    @if ($event->studentRegistrations->count())
        {{-- Faculty Pie Chart Script --}}
        <script>
            const facultyCounts = @json($facultyCounts);
            const facultyLabels = Object.keys(facultyCounts);
            const facultyData = Object.values(facultyCounts);

            const pieCtx = document.getElementById('facultyPieChart')?.getContext('2d');
            if (pieCtx) {
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: facultyLabels,
                        datasets: [{
                            label: 'Students per Faculty',
                            data: facultyData,
                            backgroundColor: [
                                '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#6366F1',
                                '#EC4899', '#8B5CF6', '#22D3EE', '#F87171', '#34D399'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
            }
        </script>
    @endif
</x-app-layout>
