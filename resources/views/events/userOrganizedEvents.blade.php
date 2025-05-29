<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events Organized by Your Club') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <!-- Header & Download Button -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                            📊 Events Organized by Your Club
                        </h3>
                        <button onclick="downloadAllReportsPDF()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download All Reports (PDF)
                        </button>
                    </div>
                    <div class="mt-6"></div>
                <!-- @if ($events->count() > 0)
                    <div class="mb-6 flex justify-end">
                        <button onclick="downloadAllReportsPDF()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download All Reports (PDF)
                        </button>
                    </div> -->

                    <!-- Search Bar -->
                        <form method="GET" action="{{ route('events.userOrganized') }}" class="flex justify-center mb-6 gap-2">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by event / program name..."
                                class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg"
                            />
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Search 🔍
                            </button>
                        </form>

                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">No</th>
                                <th class="border border-gray-300 px-4 py-2">EVENT / PROGRAM</th>
                                <th class="border border-gray-300 px-4 py-2">Date</th>
                                <th class="border border-gray-300 px-4 py-2">Report & Analysis</th>
                                <th class="border border-gray-300 px-4 py-2">Download Paperwork</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $index => $event)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->program_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $event->date }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('events.viewReport', $event->id) }}" class="btn btn-primary">
                                            View Report
                                        </a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        @if ($event->paperwork)
                                            <a href="{{ asset('storage/' . $event->paperwork) }}" class="btn btn-primary" download>
                                                Download Paperwork
                                            </a>
                                        @else
                                            <span class="text-gray-500">No paperwork uploaded</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pie Chart -->
                    <div class="mt-12">
                        <h3 class="text-xl font-bold mb-4">Student Registration Summary (Pie Chart)</h3>
                        <div class="max-w-md mx-auto">
                            <canvas id="registrationPieChart" class="w-full h-auto"></canvas>
                        </div>
                    </div>

                    <!-- Chart.js & Plugins -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

                    <script>
                        // Register Chart.js plugin
                        Chart.register(ChartDataLabels);

                        const ctx = document.getElementById('registrationPieChart').getContext('2d');

                        const chartData = {
                            labels: {!! json_encode($events->pluck('program_name')) !!},
                            datasets: [{
                                label: 'Registered Students',
                                data: {!! json_encode($events->pluck('student_registrations_count')) !!},
                                backgroundColor: [
                                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                    '#9966FF', '#FF9F40', '#E7E9ED', '#8E44AD',
                                    '#1ABC9C', '#F39C12', '#D35400', '#C0392B'
                                ],
                                borderWidth: 1
                            }]
                        };

                        const registrationChart = new Chart(ctx, {
                            type: 'pie',
                            data: chartData,
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'right',
                                    },
                                    datalabels: {
                                        color: '#fff',
                                        font: {
                                            weight: 'bold',
                                            size: 12
                                        },
                                        formatter: (value) => value,
                                    }
                                }
                            },
                            plugins: [ChartDataLabels]
                        });

                        // PDF Download Function
                        async function downloadAllReportsPDF() {
                            const { jsPDF } = window.jspdf;
                            const doc = new jsPDF();

                            doc.setFontSize(20);
                            doc.setFont(undefined, 'bold');
                            doc.text('Events Report & Analysis', 20, 20);

                            doc.setFontSize(10);
                            doc.setFont(undefined, 'normal');
                            doc.text('Generated on: ' + new Date().toLocaleDateString(), 20, 30);

                            let yPosition = 50;
                            const events = @json($events);

                            doc.setFontSize(16);
                            doc.setFont(undefined, 'bold');
                            doc.text('Events Summary', 20, yPosition);
                            yPosition += 15;

                            doc.setFontSize(10);
                            doc.setFont(undefined, 'normal');
                            doc.text('No.', 20, yPosition);
                            doc.text('Event/Program', 40, yPosition);
                            doc.text('Date', 120, yPosition);
                            doc.text('Registrations', 160, yPosition);
                            yPosition += 5;
                            doc.line(20, yPosition, 190, yPosition);
                            yPosition += 10;

                            events.forEach((event, index) => {
                                if (yPosition > 270) {
                                    doc.addPage();
                                    yPosition = 20;
                                }
                                doc.text((index + 1).toString(), 20, yPosition);
                                doc.text(event.program_name.substring(0, 25) + (event.program_name.length > 25 ? '...' : ''), 40, yPosition);
                                doc.text(event.date, 120, yPosition);
                                doc.text((event.student_registrations_count || 0).toString(), 160, yPosition);
                                yPosition += 10;
                            });

                            yPosition += 20;
                            if (yPosition > 250) {
                                doc.addPage();
                                yPosition = 20;
                            }

                            doc.setFontSize(16);
                            doc.setFont(undefined, 'bold');
                            doc.text('Statistics', 20, yPosition);
                            yPosition += 15;

                            doc.setFontSize(12);
                            doc.setFont(undefined, 'normal');
                            const totalEvents = events.length;
                            const totalRegistrations = events.reduce((sum, e) => sum + (e.student_registrations_count || 0), 0);
                            const averageRegistrations = totalEvents > 0 ? (totalRegistrations / totalEvents).toFixed(1) : 0;

                            doc.text(`Total Events: ${totalEvents}`, 20, yPosition);
                            yPosition += 10;
                            doc.text(`Total Registrations: ${totalRegistrations}`, 20, yPosition);
                            yPosition += 10;
                            doc.text(`Average Registrations per Event: ${averageRegistrations}`, 20, yPosition);
                            yPosition += 20;

                            try {
                                const canvas = document.getElementById('registrationPieChart');
                                const chartImage = canvas.toDataURL('image/png');

                                if (yPosition > 150) {
                                    doc.addPage();
                                    yPosition = 20;
                                }

                                doc.setFontSize(14);
                                doc.setFont(undefined, 'bold');
                                doc.text('Registration Distribution Chart', 20, yPosition);
                                yPosition += 10;

                                doc.addImage(chartImage, 'PNG', 20, yPosition, 160, 120);
                            } catch (error) {
                                console.log('Could not add chart to PDF:', error);
                            }

                            const fileName = `Events_Report_${new Date().toISOString().split('T')[0]}.pdf`;
                            doc.save(fileName);
                        }
                    </script>
                @else
                    <p class="text-gray-600">No events have been organized by your club.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
