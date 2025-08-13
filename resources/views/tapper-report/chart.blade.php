<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('tapper-report.detail', $nik) }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Tapper Report</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
            <span class="text-base font-light text-gray-500">Average Chart</span>
        </div>
    </div>

    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4">
        <div class="mb-4 flex justify-between items-start">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Assessment Score Average Analysis</h2>
                <p class="text-gray-600 text-sm">Grafik menunjukkan analisis data asesmen berdasarkan jumlah rata-rata
                    skor dari setiap item asesmen.</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('tapper-report.detail', $nik) }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                    <i class="ri-bar-chart-line mr-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="container mx-auto py-3">
            <div class="mb-3 mx-2 bg-white rounded-lg shadow-md shadow-black/10 p-3">
                <h2 class="text-lg font-bold text-gray-800 mb-3">Tapper Information</h2>
                <div class="grid grid-cols-7 gap-x-6 gap-y-2">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500">NIK</h3>
                        <p class="text-sm font-bold text-gray-900">{{ $tapperInfo->nik_penyadap }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500">Nama</h3>
                        <p class="text-sm font-bold text-gray-900">{{ $tapperInfo->nama_penyadap }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500">Departemen</h3>
                        <p class="text-sm font-bold text-gray-900">{{ $tapperInfo->dept }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500">Kemandoran</h3>
                        <p class="text-sm font-bold text-gray-900">{{ $tapperInfo->kemandoran }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500">Date</h3>
                        <p class="text-sm font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($tapperInfo->tgl_inspeksi)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500">Jenis Kulit</h3>
                        <p class="text-sm font-bold text-gray-900">{{ $tapperInfo->jenis_kulit_pohon }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500">Kelas </h3>
                        <p class="text-sm font-bold text-gray-900">
                            @if ($tapperInfo->kelas_perawan != null || $tapperInfo->kelas_perawan == '-')
                                {{ $tapperInfo->kelas_perawan }}
                            @elseif ($tapperInfo->kelas_pulihan != null || $tapperInfo->kelas_pulihan == '-')
                                {{ $tapperInfo->kelas_pulihan }}
                            @else
                                {{ $tapperInfo->kelas_nta }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-md mx-2 mb-3">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Item Average Score Bar Chart</h3>
                <div style="height: 300px;"> <canvas id="itemSumChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-md mx-2 mb-3">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Detailed Average Statistics</h3>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-green-600 text-white">
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Item Code
                                </th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider">Description
                                </th>
                                <th class="px-3 py-2 text-right text-xs font-medium uppercase tracking-wider">Average
                                </th>
                                <th class="px-3 py-2 text-right text-xs font-medium uppercase tracking-wider">Percentage
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalSum = collect($itemSums)->sum('sum');
                                $totalPercentageSum = 0;
                            @endphp
                            @foreach ($itemSums as $index => $item)
                                <tr class="border-b border-gray-200 {{ $loop->even ? 'bg-green-50' : 'bg-white' }}">
                                    <td class="px-3 py-1 text-sm">{{ $index + 1 }}</td>
                                    <td class="px-3 py-1 text-sm font-medium">{{ $item['label'] }}</td>
                                    <td class="px-3 py-1 text-sm">{{ $item['description'] }}</td>
                                    <td class="px-3 py-1 text-sm text-right font-semibold">
                                        {{ number_format($item['sum'], 1) }}</td>
                                    <td class="px-3 py-1 text-sm text-right">
                                        @php
                                            // Calculate the percentage for the current item
                                            $itemPercentage = $totalSum > 0 ? ($item['sum'] / $totalSum) * 100 : 0;
                                            // Add it to the total percentage sum
                                            $totalPercentageSum += $itemPercentage;
                                        @endphp
                                        {{ number_format($itemPercentage, 1) }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-green-700 text-white font-bold">
                                <th colspan="3" class="px-3 py-2 text-right text-sm">Grand Total</th>
                                <th class="px-3 py-2 text-right text-sm">{{ number_format($totalSum, 1) }}</th>
                                {{-- Display the accumulated totalPercentageSum here --}}
                                <th class="px-3 py-2 text-right text-sm">{{ number_format($totalPercentageSum) }}%
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Toggle department filter based on division selection
        function toggleDeptFilter(divisionValue) {
            const deptFilter = document.getElementById('deptFilter');
            if (divisionValue) {
                deptFilter.disabled = true;
                deptFilter.value = '';
            } else {
                deptFilter.disabled = false;
            }
        }

        // Prepare data for Chart.js
        const itemData = @json($itemSums);

        // Extract labels and data
        const labels = itemData.map(item => item.label);
        const data = itemData.map(item => item.sum);
        const descriptions = itemData.map(item => item.description);

        // Create the chart
        const ctx = document.getElementById('itemSumChart').getContext('2d');
        const itemSumChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '',
                    data: data,
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                        position: 'top',
                        labels: {
                            color: 'rgb(55, 65, 81)',
                            font: {
                                size: 14,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                const index = context[0].dataIndex;
                                return labels[index];
                            },
                            label: function(context) {
                                const index = context.dataIndex;
                                return [
                                    'Avg Score: ' + context.parsed.y.toLocaleString(),
                                    'Description: ' + descriptions[index]
                                ];
                            }
                        },
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1,
                        cornerRadius: 6,
                        displayColors: false,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Assessment Items',
                            color: 'rgb(55, 65, 81)',
                            font: {
                                size: 14,
                                weight: '600'
                            }
                        },
                        ticks: {
                            color: 'rgb(75, 85, 99)',
                            font: {
                                size: 11
                            },
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            color: 'rgba(156, 163, 175, 0.2)'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Avg. Score',
                            color: 'rgb(55, 65, 81)',
                            font: {
                                size: 14,
                                weight: '600'
                            }
                        },
                        ticks: {
                            color: 'rgb(75, 85, 99)',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        },
                        grid: {
                            color: 'rgba(156, 163, 175, 0.2)'
                        },
                        beginAtZero: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                elements: {
                    bar: {
                        hoverBackgroundColor: 'rgba(239, 68, 68, 0.8)',
                        hoverBorderColor: 'rgb(239, 68, 68)'
                    }
                }
            }
        });
    </script>
</x-app-layout>
