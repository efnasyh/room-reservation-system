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
                    <!-- <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('TOTAL EVENTS & CLUB COUNTS') }}</h3> -->
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                            📊 Total Events & Club Counts
                        </h3>
                        <!-- Download PDF Button -->
                        <button onclick="downloadEventsPerClubPDF()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Report (PDF)
                        </button>
                    </div>
</div>
<div class="mt-6"></div>
                    <!-- Animated Counters Row -->
                    <div class="flex flex-wrap md:flex-nowrap gap-4 overflow-x-auto pb-4">
                        <div class="flex-1 min-w-[200px] bg-blue-100 p-4 rounded-lg shadow flex flex-col items-center">
                            <div class="text-blue-600 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6m-3 4a9 9 0 110-18 9 9 0 010 18z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">Total Events</p>
                            <p class="text-2xl font-bold counter" data-target="{{ $totalEvents }}">0</p>
                        </div>

                        <div class="flex-1 min-w-[200px] bg-green-100 p-4 rounded-lg shadow flex flex-col items-center">
                            <div class="text-green-600 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l6 6-6 6M21 7l-6 6 6 6"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">Residential College Clubs</p>
                            <p class="text-2xl font-bold counter" data-target="{{ $residentialClubCount }}">0</p>
                        </div>

                        <div class="flex-1 min-w-[200px] bg-yellow-100 p-4 rounded-lg shadow flex flex-col items-center">
                            <div class="text-yellow-600 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 10-8 0v2m0 0v10m8-10v10m-8 0h8"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">Uniform Clubs</p>
                            <p class="text-2xl font-bold counter" data-target="{{ $uniformClubCount }}">0</p>
                        </div>

                        <div class="flex-1 min-w-[200px] bg-pink-100 p-4 rounded-lg shadow flex flex-col items-center">
                            <div class="text-pink-600 mb-2">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8m-4 0v10m0 0H8m4 0h4"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600">Association / Clubs</p>
                            <p class="text-2xl font-bold counter" data-target="{{ $associationClubCount }}">0</p>
                        </div>
                    </div>

                    <div class="mt-6"></div>

                    <!-- Filter Buttons -->
                    <div class="flex justify-center gap-4 mb-6 flex-wrap">
                        <a href="{{ route('events.report', ['filter' => 'All']) }}">
                            <button class="px-4 py-2 {{ request('filter') == 'All' || request('filter') == null ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                                All
                            </button>
                        </a>

                        <a href="{{ route('events.report', ['filter' => 'Residential College']) }}">
                            <button class="px-4 py-2 {{ request('filter') == 'Residential College' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                                Residential College
                            </button>
                        </a>

                        <a href="{{ route('events.report', ['filter' => 'Association / Club']) }}">
                            <button class="px-4 py-2 {{ request('filter') == 'Association / Club' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                                Association / Club
                            </button>
                        </a>

                        <a href="{{ route('events.report', ['filter' => 'Uniform']) }}">
                            <button class="px-4 py-2 {{ request('filter') == 'Uniform' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                                Uniform
                            </button>
                        </a>
                    </div>

                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('events.report') }}" class="flex justify-center mb-6 gap-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by club name..."
                            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg"
                        />
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Search 🔍
                        </button>
                    </form>

                    <!-- Table -->
                    <div class="flex justify-center mt-6 overflow-x-auto">
                        <table class="table-auto border-collapse border border-gray-400 mx-auto mt-6 min-w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 border border-gray-400 text-left">{{ __('No') }}</th>
                                    <th class="px-4 py-2 border border-gray-400 text-left">{{ __('Club Name') }}</th>
                                    <th class="px-4 py-2 border border-gray-400 text-left">{{ __('Total Events') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventsPerClub as $index => $event)
                                    <tr>
                                        <td class="px-4 py-2 border border-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border border-gray-400">{{ $event->club_name }}</td>
                                        <td class="px-4 py-2 border border-gray-400">{{ $event->total_events }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pie chart -->
                    <div class="mt-8 max-w-3xl mx-auto">
                        <canvas id="eventsByClubPieChart" width="400" height="400"></canvas>
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
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                counter.innerText = '0';
                const updateCounter = () => {
                    const target = +counter.getAttribute('data-target');
                    const c = +counter.innerText;
                    const increment = target / 200;
                    if (c < target) {
                        counter.innerText = `${Math.ceil(c + increment)}`;
                        setTimeout(updateCounter, 10);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCounter();
            });

            const eventsPerClub = @json($eventsPerClub);
            const labels = eventsPerClub.map(item => item.club_name);
            const data = eventsPerClub.map(item => item.total_events);
            const ctx = document.getElementById('eventsByClubPieChart').getContext('2d');

            Chart.register(ChartDataLabels);

            const chartData = {
                labels: labels,
                datasets: [{
                    label: 'Total Events',
                    data: data,
                    backgroundColor: generateColorPalette(data.length),
                    hoverOffset: 10
                }]
            };

            const config = {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 15, padding: 10 } },
                        title: { display: true, text: 'Total Events by Club' },
                        datalabels: {
                            color: '#fff',
                            formatter: (value) => value,
                            font: { weight: 'bold', size: 14 },
                            anchor: 'center',
                            align: 'center',
                        }
                    }
                },
                plugins: [ChartDataLabels]
            };

            new Chart(ctx, config);
        });

        function generateColorPalette(numColors) {
            const colors = [];
            const hueStep = 360 / numColors;
            for (let i = 0; i < numColors; i++) {
                colors.push(`hsl(${i * hueStep}, 70%, 50%)`);
            }
            return colors;
        }

        async function downloadEventsPerClubPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFontSize(18);
            doc.setFont(undefined, 'bold');
            doc.text('Total Events by Club', 20, 20);

            doc.setFontSize(10);
            doc.setFont(undefined, 'normal');
            doc.text('Generated on: ' + new Date().toLocaleDateString(), 20, 28);

            let y = 40;

            doc.setFontSize(12);
            doc.setFont(undefined, 'bold');
            doc.text('No.', 20, y);
            doc.text('Club Name', 40, y);
            doc.text('Total Events', 140, y);
            y += 5;
            doc.line(20, y, 190, y);
            y += 8;

            const eventsPerClub = @json($eventsPerClub);
            doc.setFont(undefined, 'normal');
            eventsPerClub.forEach((event, i) => {
                if (y > 200) {
                    doc.addPage();
                    y = 20;
                }
                doc.text(String(i + 1), 20, y);
                doc.text(event.club_name.substring(0, 40), 40, y);
                doc.text(String(event.total_events), 140, y, { align: 'right' });
                y += 8;
            });

            const canvas = document.getElementById('eventsByClubPieChart');
            const imgData = canvas.toDataURL('image/png');
            doc.addPage();
            doc.addImage(imgData, 'PNG', 15, 20, 180, 180);

            const filename = `Events_Per_Club_Report_${new Date().toISOString().split('T')[0]}.pdf`;
            doc.save(filename);
        }
    </script>
</x-app-layout>
