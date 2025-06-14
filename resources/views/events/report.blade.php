<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white shadow-lg rounded-2xl ring-1 ring-gray-200">
                <div class="w-full space-y-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                            📊 Total Events & Club Counts
                        </h3>
                        <button onclick="downloadEventsPerClubPDF()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Report (PDF)
                        </button>
                    </div>

                    <!-- Counters -->
                    <div class="flex flex-wrap md:flex-nowrap gap-4 overflow-x-auto pb-4">
                        @foreach ([
                            ['color' => 'blue', 'label' => 'Total Events', 'value' => $totalEvents],
                            ['color' => 'green', 'label' => 'Residential College Clubs', 'value' => $residentialClubCount],
                            ['color' => 'yellow', 'label' => 'Uniform Clubs', 'value' => $uniformClubCount],
                            ['color' => 'pink', 'label' => 'Association / Clubs', 'value' => $associationClubCount],
                        ] as $item)
                            <div class="flex-1 min-w-[200px] bg-{{ $item['color'] }}-100 p-4 rounded-lg shadow flex flex-col items-center">
                                <div class="text-{{ $item['color'] }}-600 mb-2">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600">{{ $item['label'] }}</p>
                                <p class="text-2xl font-bold counter" data-target="{{ $item['value'] }}">0</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Filters -->
                    <div class="flex justify-center gap-4 mb-6 flex-wrap">
                        @foreach(['All', 'Residential College', 'Association / Club', 'Uniform'] as $category)
                            <a href="{{ route('events.report', ['filter' => $category]) }}">
                                <button class="px-4 py-2 {{ request('filter') == $category || (!request('filter') && $category == 'All') ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                                    {{ $category }}
                                </button>
                            </a>
                        @endforeach
                    </div>

                    <!-- Search -->
                    <form method="GET" action="{{ route('events.report') }}" class="flex justify-center mb-6 gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by club name..." class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg" />
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search 🔍</button>
                    </form>

                    <!-- Table -->
                    <div class="flex justify-center mt-6 overflow-x-auto">
                        <table class="table-auto border-collapse border border-gray-400 mx-auto mt-6 min-w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 border border-gray-400 text-left">No</th>
                                    <th class="px-4 py-2 border border-gray-400 text-left">Club Name</th>
                                    <th class="px-4 py-2 border border-gray-400 text-left">Total Events</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventsPerClub as $index => $event)
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border border-gray-400 break-words max-w-[300px]">{{ $event->club_name }}</td>
                                        <td class="px-4 py-2 border border-gray-400">{{ $event->total_events }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

<!-- Pie Chart -->
<div class="mt-8 flex justify-center">
    <canvas id="eventsByClubPieChart" width="300" height="300"></canvas>
</div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Counter animation
            document.querySelectorAll('.counter').forEach(counter => {
                const target = +counter.dataset.target;
                let current = 0;
                const step = Math.ceil(target / 200);
                const update = () => {
                    current += step;
                    counter.innerText = current >= target ? target : current;
                    if (current < target) setTimeout(update, 10);
                };
                update();
            });

            // Filter clubs with event > 0 for chart
            const eventsPerClubRaw = @json($eventsPerClub);
            const filteredData = eventsPerClubRaw.filter(e => e.total_events > 0);

            const ctx = document.getElementById('eventsByClubPieChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: filteredData.map(e => e.club_name),
                    datasets: [{
                        data: filteredData.map(e => e.total_events),
                        backgroundColor: filteredData.map((_, i) => `hsl(${i * 360 / filteredData.length}, 70%, 50%)`)
                    }]
                },
                options: {
                    plugins: {
                        datalabels: {
                            color: '#fff',
                            formatter: val => val,
                            font: { weight: 'bold', size: 14 }
                        },
                        legend: { position: 'bottom' },
                        title: { display: true, text: 'Total Events by Club' }
                    }
                },
                plugins: [ChartDataLabels]
            });
        });

        async function downloadEventsPerClubPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const eventsPerClub = @json($eventsPerClub);

            doc.setFontSize(18).text('Total Events by Club', 20, 20);
            doc.setFontSize(10).text('Generated: ' + new Date().toLocaleDateString(), 20, 28);

            let y = 40;
            doc.setFontSize(12).text('No.', 20, y);
            doc.text('Club Name', 40, y);
            doc.text('Total Events', 160, y);
            y += 8;
            doc.line(20, y, 190, y);
            y += 8;

            eventsPerClub.forEach((event, i) => {
                if (y > 260) {
                    doc.addPage();
                    y = 20;
                }
                doc.text(String(i + 1), 20, y);
                const wrappedText = doc.splitTextToSize(event.club_name, 100);
                doc.text(wrappedText, 40, y);
                doc.text(String(event.total_events), 160, y);
                y += (wrappedText.length * 6);
            });

            const canvas = document.getElementById('eventsByClubPieChart');
            const imgData = canvas.toDataURL('image/png');
            doc.addPage();
            doc.addImage(imgData, 'PNG', 15, 20, 180, 180);
            doc.save(`Events_Per_Club_Report_${new Date().toISOString().split('T')[0]}.pdf`);
        }
    </script>
</x-app-layout>
