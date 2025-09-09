<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('tapper-report.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Tapper Report</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
            <span class="text-base font-medium text-gray-700">{{ $tapperInfo->nama_penyadap }}</span>
        </div>
        <div>
            <a href="{{ route('tapper-report.index') }}"
                class="px-3 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200 text-sm">
                <i class="ri-arrow-left-line mr-1"></i>
                Back to List
            </a>
        </div>
    </div>

    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4" id="exportSection">

        <div
            class="mb-3 mx-2 bg-white rounded-lg shadow-md shadow-black/10 p-3 flex flex-col md:flex-row md:justify-between md:items-start gap-4">
            <div class="bg-white rounded-lg shadow-sm p-3 md:w-1/2"> {{-- Added md:w-1/2 to give it half width on medium screens and up --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2"> {{-- Adjusted grid to 2 columns for smaller info display --}}
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">NIK</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $tapperInfo->nik_penyadap }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Nama</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $tapperInfo->nama_penyadap }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Departemen</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $tapperInfo->dept }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Kemandoran</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $tapperInfo->kemandoran }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm md:w-1/2"> {{-- Added md:w-1/2 to give it half width on medium screens and up --}}
                <form action="{{ route('tapper-report.detail', $tapperInfo->nik_penyadap) }}" method="GET"
                    class="flex flex-col md:flex-row md:items-end gap-3">
                    <div>
                        <label for="date_from" class="block text-xs font-medium text-gray-700 mb-0.5">Date From</label>
                        <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                            class="px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs w-full">
                    </div>
                    <div>
                        <label for="date_to" class="block text-xs font-medium text-gray-700 mb-0.5">Date To</label>
                        <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                            class="px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs w-full">
                    </div>
                    <div class="flex space-x-2 mt-auto">
                        <button type="submit"
                            class="px-3 py-1.5 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 text-xs">
                            <i class="ri-filter-line mr-1"></i>
                            Filter
                        </button>
                        <button type="button" id="btnExport"
                            class="px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200 text-xs">
                            <i class="ri-file-download-line mr-1"></i>
                            Export PDF
                        </button>

                        @if (!empty($filters['date_from']) || !empty($filters['date_to']))
                            <a href="{{ route('tapper-report.detail', $tapperInfo->nik_penyadap) }}"
                                class="px-3 py-1.5 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200 text-xs">
                                <i class="ri-refresh-line mr-1"></i>
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- <!-- Summary Statistics -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-blue-500">
                <h3 class="text-sm font-medium text-gray-500">Total Assessments</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $summary->total_assessments }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-green-500">
                <h3 class="text-sm font-medium text-gray-500">Average Score</h3>
                <p class="text-2xl font-bold text-green-600">{{ $summary->avg_score }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-yellow-500">
                <h3 class="text-sm font-medium text-gray-500">First Assessment</h3>
                <p class="text-lg font-semibold text-yellow-600">{{ \Carbon\Carbon::parse($summary->first_assessment)->format('M Y') }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-purple-500">
                <h3 class="text-sm font-medium text-gray-500">Last Assessment</h3>
                <p class="text-lg font-semibold text-purple-600">{{ \Carbon\Carbon::parse($summary->last_assessment)->format('M Y') }}</p>
            </div>
        </div> --}}

        <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-3 flex flex-col md:flex-row gap-4">
            {{-- This is the MAIN container. Now uses md:flex-row for side-by-side on larger screens. --}}
            {{-- It has mx-2 for overall page margin --}}

            <div class="bg-white rounded-lg shadow-sm overflow-hidden w-full md:w-2/3"> {{-- Table takes 2/3 width on medium+ screens --}}
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-800">a) Assessment History
                        <a href="{{ route('tapper-report.chart', $tapperInfo->nik_penyadap) }}"
                            class="px-3 py-1.5 bg-blue-400 text-white rounded-md hover:bg-blue-600 transition duration-200 text-xs">Chart</a>
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Inspection By</th>
                                <th
                                    class="px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Panel Sadap</th>
                                <th
                                    class="px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Task</th>
                                <th
                                    class="px-2 py-1 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Score</th>
                                <th
                                    class="px-2 py-1 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Kelas Perawan</th>
                                <th
                                    class="px-2 py-1 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Kelas Pulihan</th>
                                <th
                                    class="px-2 py-1 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Kelas NTA</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assessments as $assessment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-700">
                                        {{ ($assessments->currentPage() - 1) * $assessments->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($assessment->tgl_inspeksi)->format('d M Y') }}
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-700">
                                        {{ $assessment->nama_inspektur }}</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-700">
                                        {{ $assessment->panel_sadap }}</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-700">
                                        {{ $assessment->task }}</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center">
                                        <a href="{{ route('tapper-report.single-chart', [$tapperInfo->nik_penyadap, $assessment->tgl_inspeksi]) }}"
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 hover:bg-green-200 hover:text-green-900 transition-colors duration-150">
                                            {{ $assessment->nilai }}
                                        </a>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center">
                                        @if ($assessment->kelas_perawan)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $assessment->kelas_perawan }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center">
                                        @if ($assessment->kelas_pulihan)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                {{ $assessment->kelas_pulihan }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center">
                                        @if ($assessment->kelas_nta)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                {{ $assessment->kelas_nta }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                        <i class="ri-file-list-line text-3xl text-gray-300 mb-2"></i>
                                        <p class="text-sm">No assessment history found for the selected period.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($assessments->isNotEmpty())
                            <tfoot>
                                <tr class="bg-gray-100 font-bold">
                                    <td colspan="6" class="px-2 py-2 text-right text-sm">Rata-rata Score:</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center">
                                        {{ number_format($assessments->avg('nilai'), 2) }}
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center">-</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center">-</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-center">-</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-800">b) Training Data (Tapping Quality)
                    </h3>
                </div>
                <div class="">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th rowspan="2"
                                    class="border border-gray-200 px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    No</th>
                                <th colspan="2"
                                    class="border border-gray-200 px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Teori</th>
                                <th colspan="2"
                                    class="border border-gray-200 px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Praktek (Kelas Sadap)</th>
                                <th rowspan="2"
                                    class="border border-gray-200 px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Judge</th>
                            </tr>
                            <tr>
                                <th
                                    class="border border-gray-200 px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="border border-gray-200 px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Score</th>
                                <th
                                    class="border border-gray-200 px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="border border-gray-200 px-2 py-1 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Score</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pairedData as $pair)
                                <tr class="hover:bg-gray-50">
                                    <td
                                        class="border border-gray-200 px-2 py-1 whitespace-nowrap text-sm text-gray-700">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td
                                        class="border border-gray-200 px-2 py-1 whitespace-nowrap text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($pair['teori']->from_date)->format('d M Y') }}
                                    </td>
                                    <td
                                        class="border border-gray-200 px-2 py-1 whitespace-nowrap text-sm text-gray-700">

                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $pair['teori']->score }}
                                        </span>
                                    </td>
                                    <td
                                        class="border border-gray-200 px-2 py-1 whitespace-nowrap text-sm text-gray-700">
                                        {{ $pair['praktek'] ? \Carbon\Carbon::parse($pair['praktek']->from_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td
                                        class="border border-gray-200 px-2 py-1 whitespace-nowrap text-sm text-gray-700">

                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $pair['praktek'] ? $pair['praktek']->score : '-' }}
                                        </span>
                                    </td>
                                    <td
                                        class="border border-gray-200 px-2 py-1 whitespace-nowrap text-sm text-gray-700">
                                        {{ $pair['teori']->ket }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-2 py-1 text-center text-gray-500">
                                        <i class="ri-file-list-line text-3xl text-gray-300 mb-2"></i>
                                        <p class="text-sm">No training data found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Chart --}}
            @if ($chartData->count() > 1)
                <div class="w-full md:w-1/3 flex flex-col gap-4">
                    {{-- Charts section takes 1/3 width on medium+ screens --}}

                    <div class="bg-white rounded-lg shadow-sm p-3 w-full">
                        <div class="mb-3">
                            <h3 class="text-base font-medium text-gray-900">Score History Chart</h3>
                            <p class="text-xs text-gray-500">Assessment scores over the time</p>
                        </div>
                        <div class="h-100">
                            <canvas id="scoreChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-3 w-full">
                        <div class="mb-3">
                            <h3 class="text-base font-medium text-gray-900">Skor Tingkat Pemahaman Materi</h3>
                        </div>
                        <div class="flex flex-col gap-1">
                            <div class="flex gap-2">
                                <div class="bg-gray-100 p-2 rounded-md flex-grow">
                                    <p class="text-sm font-medium">1. Tidak paham materi (50%)</p>
                                </div>
                                <div class="bg-gray-100 p-2 rounded-md flex-grow">
                                    <p class="text-sm font-medium">2. Paham sebagian (50-69%)</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="bg-gray-100 p-2 rounded-md flex-grow">
                                    <p class="text-sm font-medium">3. Paham materi (70-90%)</p>
                                </div>
                                <div class="bg-gray-100 p-2 rounded-md flex-grow">
                                    <p class="text-sm font-medium">4. Paham hampir seluruh materi (>90%)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($assessments->hasPages())
            <div class="mt-4">
                <div class="pagination-wrapper">
                    {{ $assessments->appends(request()->query())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Chart.js for Score History -->
    @if ($chartData->count() > 1)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('scoreChart').getContext('2d');

                const chartData = @json($chartData);
                const chartDataQueryRank = @json($chartDataQueryRank);

                // Process data for chart
                const labels = chartData.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                });

                const scores = chartData.map(item => item.score);

                Chart.register(ChartDataLabels);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Assessment Score',
                            data: scores,
                            borderColor: '#3572EF',
                            backgroundColor: '#3572EF',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: 'rgb(255, 255, 255)',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }, ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 50,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                title: {
                                    display: true,
                                    text: 'Score'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                title: {
                                    display: true,
                                    text: 'Assessment Date'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false,
                                position: 'top'
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                borderColor: 'rgb(59, 130, 246)',
                                borderWidth: 1,
                                displayColors: false,
                                callbacks: {
                                    title: function(context) {
                                        return 'Assessment Date: ' + context[0].label;
                                    },
                                    label: function(context) {
                                        return 'Score: ' + context.parsed.y;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#000',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: (value) => value,
                                anchor: 'end', // position relative to segment
                                align: 'end', // direction (start, end, center)
                                offset: 10 // how far from the segment
                            }
                        }
                    }
                });

            });
        </script>

        <script>
            document.getElementById("btnExport").addEventListener("click", function() {
                const {
                    jsPDF
                } = window.jspdf;
                const element = document.getElementById("exportSection");

                htmlToImage.toPng(element, {
                        cacheBust: true
                    })
                    .then((dataUrl) => {
                        // 📌 Landscape mode
                        const pdf = new jsPDF("l", "mm", "a4");

                        const img = new Image();
                        img.src = dataUrl;
                        img.onload = () => {
                            const pdfWidth = pdf.internal.pageSize.getWidth();
                            const pdfHeight = (img.height * pdfWidth) / img.width;
                            const pageHeight = pdf.internal.pageSize.getHeight();

                            // kalau tinggi gambar > tinggi halaman, otomatis multi-page
                            if (pdfHeight > pageHeight) {
                                let position = 0;
                                while (position < pdfHeight) {
                                    pdf.addImage(
                                        img,
                                        "PNG",
                                        0,
                                        position * -1,
                                        pdfWidth,
                                        pdfHeight
                                    );
                                    position += pageHeight;
                                    if (position < pdfHeight) pdf.addPage();
                                }
                            } else {
                                pdf.addImage(img, "PNG", 0, 0, pdfWidth, pdfHeight);
                            }

                            pdf.save("tapping-report.pdf");
                        };
                    })
                    .catch((error) => {
                        console.error("Export error:", error);
                    });
            });
        </script>
    @endif
</x-app-layout>
