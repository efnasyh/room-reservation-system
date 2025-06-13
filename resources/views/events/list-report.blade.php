<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('📋 Event List Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white shadow-lg rounded-2xl ring-1 ring-gray-200">
                <div class="w-full space-y-6">

                    <!-- Header & Download Button -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                            📊 All Events From All Clubs
                        </h3>
                        <button onclick="downloadEventListPDF()" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition">
                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download All Events in PDF
                        </button>
                    </div>

                    <!-- Stat Cards with Animated Counters -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                            $cards = [
                                ['title' => '🧾 Total Events', 'value' => $totalEvents, 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                ['title' => '✅ Approved Events', 'value' => $approved, 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                ['title' => '❌ Rejected Events', 'value' => $rejected, 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                ['title' => '🎓 Association / Club', 'value' => $byAssociation, 'bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                                ['title' => '🪖 Uniform Body', 'value' => $byUniform, 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                ['title' => '🏠 Residential College', 'value' => $byResidential, 'bg' => 'bg-pink-100', 'text' => 'text-pink-800'],
                            ];
                        @endphp

                        @foreach ($cards as $index => $card)
                            <div
                                class="{{ $card['bg'] }} {{ $card['text'] }} rounded-xl p-6 shadow-lg transform transition duration-500 hover:scale-105 animate-fade-in"
                                style="animation-delay: {{ $index * 0.1 }}s; animation-fill-mode: both;"
                            >
                                <div class="text-5xl font-extrabold counter" data-target="{{ $card['value'] }}">0</div>
                                <div class="mt-2 text-md font-medium">{{ $card['title'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('events.listReport') }}" class="flex flex-col sm:flex-row justify-center items-center gap-3 mt-4">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="🔍 Search by club or event name"
                            class="w-full sm:max-w-md px-4 py-2 border border-gray-300 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                            Search
                        </button>
                    </form>

                    <!-- Event Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-300 mt-6 shadow-sm">
                        <table class="min-w-full text-left text-sm table-auto border-collapse">
                            <thead class="bg-gray-200 text-gray-800 font-semibold">
                                <tr>
                                    <th class="px-4 py-3 border border-gray-300">No</th>
                                    <th class="px-4 py-3 border border-gray-300">Event Name</th>
                                    <th class="px-4 py-3 border border-gray-300">Date</th>
                                    <th class="px-4 py-3 border border-gray-300">Club Name</th>
                                    <th class="px-4 py-3 border border-gray-300">Status</th>
                                    <th class="px-4 py-3 border border-gray-300">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $index => $event)
                                    <tr class="hover:bg-gray-100 transition">
                                        <td class="px-4 py-2 border border-gray-300">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $event->program_name }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $event->date }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $event->club_name }}</td>
                                        <td class="px-4 py-2 border border-gray-300">{{ $event->status }}</td>
                                        <td class="px-4 py-2 border border-gray-300">
                                            @if ($event->paperwork)
                                                <a href="{{ asset('storage/' . $event->paperwork) }}" class="text-blue-600 hover:underline font-medium" download>
                                                    Download Paperwork 📄
                                                </a>
                                            @else
                                                <span class="text-gray-500 italic">No paperwork</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Chart Section -->
                    <div class="mt-10">
                        <h4 class="text-center text-lg font-semibold text-gray-800 mb-4">📈 Event Status Overview</h4>
                        <div class="max-w-md mx-auto bg-white rounded-lg shadow p-4">
                            <canvas id="eventStatusPieChart"></canvas>
                        </div>
                    </div>

                    <!-- Styles for animation -->
                    <style>
                        @keyframes fade-in {
                            from { opacity: 0; transform: translateY(20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        .animate-fade-in {
                            animation: fade-in 0.7s ease-out;
                        }
                    </style>

                    <!-- Scripts -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

                   <script>
    let chartInstance;

    async function downloadEventListPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const events = @json($events);

        doc.setFontSize(16);
        doc.text("📋 Event List Report", 14, 15);
        doc.setFontSize(10);
        doc.text("Generated on: " + new Date().toLocaleString(), 14, 22);

        const tableData = events.map((event, index) => [
            index + 1,
            event.program_name,
            event.date,
            event.club_name,
            event.status
        ]);

        doc.autoTable({
            head: [["No", "Event Name", "Date", "Club Name", "Status"]],
            body: tableData,
            startY: 30,
            theme: 'striped',
            styles: {
                fontSize: 9,
                cellPadding: 3
            },
            headStyles: {
                fillColor: [52, 152, 219]
            },
            columnStyles: {
                0: { cellWidth: 10 },
                1: { cellWidth: 50 },
                2: { cellWidth: 25 },
                3: { cellWidth: 55 },
                4: { cellWidth: 25 }
            }
        });

        // 🟠 Convert pie chart to image and add to PDF
        const chartCanvas = document.getElementById("eventStatusPieChart");
        const imageData = chartCanvas.toDataURL("image/png", 1.0);

        doc.addPage();
        doc.setFontSize(14);
        doc.text("📈 Event Status Pie Chart", 14, 20);
        doc.addImage(imageData, 'PNG', 40, 30, 130, 100); // adjust width/height as needed

        // Footer
        doc.setFontSize(9);
        doc.text('Page ' + doc.internal.getNumberOfPages(), 180, 290, { align: 'right' });

        const filename = `Event_List_Report_${new Date().toISOString().split('T')[0]}.pdf`;
        doc.save(filename);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const events = @json($events);
        let approvedCount = 0;
        let rejectedCount = 0;

        events.forEach(event => {
            const status = event.status.toLowerCase();
            if (status === 'approved') approvedCount++;
            else if (status === 'rejected') rejectedCount++;
        });

        const ctx = document.getElementById('eventStatusPieChart').getContext('2d');
        chartInstance = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Approved', 'Rejected'],
                datasets: [{
                    label: 'Event Status',
                    data: [approvedCount, rejectedCount],
                    backgroundColor: ['#34D399', '#EF4444'],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: {
                        display: true,
                        text: 'Total Approved vs Rejected Events'
                    },
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold', size: 14 },
                        formatter: value => value
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Animated counters
        document.querySelectorAll(".counter").forEach(counter => {
            const target = parseInt(counter.getAttribute("data-target"));
            let count = 0;
            const duration = 1000;
            const start = performance.now();

            const step = (timestamp) => {
                const elapsed = timestamp - start;
                const progress = Math.min(elapsed / duration, 1);
                counter.textContent = Math.floor(progress * target);
                if (progress < 1) requestAnimationFrame(step);
                else counter.textContent = target;
            };
            requestAnimationFrame(step);
        });
    });
</script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
