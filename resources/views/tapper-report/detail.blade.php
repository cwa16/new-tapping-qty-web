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
            <a href="{{ route('tapper-report.index') }}" class="px-3 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200 text-sm">
                <i class="ri-arrow-left-line mr-1"></i>
                Back to List
            </a>
        </div>
    </div>

    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4">
        <!-- Tapper Information Card -->
        <div class="mb-4 bg-white rounded-lg shadow-sm p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">NIK</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $tapperInfo->nik_penyadap }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Nama</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $tapperInfo->nama_penyadap }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Departemen</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $tapperInfo->dept }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Kemandoran</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $tapperInfo->kemandoran }}</p>
                </div>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="mb-4 bg-white rounded-lg p-4 shadow-sm">
            <form action="{{ route('tapper-report.detail', $tapperInfo->nik_penyadap) }}" method="GET" class="flex items-end space-x-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" 
                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" 
                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 text-sm">
                        <i class="ri-filter-line mr-1"></i>
                        Filter
                    </button>
                    @if(!empty($filters['date_from']) || !empty($filters['date_to']))
                        <a href="{{ route('tapper-report.detail', $tapperInfo->nik_penyadap) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200 text-sm">
                            <i class="ri-refresh-line mr-1"></i>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Score History Chart -->
        @if($chartData->count() > 1)
            <div class="mb-4 bg-white rounded-lg shadow-sm p-4">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Score History</h3>
                    <p class="text-sm text-gray-500">Assessment scores over time</p>
                </div>
                <div class="h-80">
                    <canvas id="scoreChart"></canvas>
                </div>
            </div>
        @endif

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

        <!-- Assessment History Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">History</h3>
            </div>
            <div class="overflow-x-auto p-2">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="bg-blue-500">
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Panel Sadap</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Task</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Status</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Score</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Kelas Perawan</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Kelas Pulihan</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Kelas NTA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($assessments as $assessment)
                            <tr class="hover:bg-gray-200 {{ $loop->iteration % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="px-4 py-3 text-sm">{{ ($assessments->currentPage() - 1) * $assessments->perPage() + $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($assessment->tgl_inspeksi)->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $assessment->panel_sadap }}</td>
                                <td class="px-4 py-3 text-sm">{{ $assessment->task }}</td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ">
                                        {{ $assessment->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                        {{ $assessment->nilai }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    @if($assessment->kelas_perawan)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium ">
                                            {{ $assessment->kelas_perawan }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    @if($assessment->kelas_pulihan)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium ">
                                            {{ $assessment->kelas_pulihan }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    @if($assessment->kelas_nta)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium">
                                            {{ $assessment->kelas_nta }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                    <i class="ri-file-list-line text-4xl text-gray-300 mb-2"></i>
                                    <p>No assessment history found for the selected period.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($assessments->hasPages())
            <div class="mt-4">
                <div class="pagination-wrapper">
                    {{ $assessments->appends(request()->query())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Chart.js for Score History -->
    @if($chartData->count() > 1)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('scoreChart').getContext('2d');
                
                const chartData = @json($chartData);
                
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

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Assessment Score',
                            data: scores,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: 'rgb(255, 255, 255)',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
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
                                display: true,
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
                            }
                        }
                    }
                });
            });
        </script>
    @endif
</x-app-layout>
