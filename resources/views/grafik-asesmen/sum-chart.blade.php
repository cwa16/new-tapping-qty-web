<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('grafik-asesmen.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Grafik Asesmen</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
            <span class="text-base font-light text-gray-500">Sum Chart</span>
        </div>
    </div>
    
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4">
        <div class="mb-4 flex justify-between items-start">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Assessment Score Sum Analysis</h2>
                <p class="text-gray-600 text-sm">Grafik menunjukkan analisis data asesmen berdasarkan jumlah total skor dari setiap item asesmen.</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('grafik-asesmen.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                    <i class="ri-bar-chart-line mr-1"></i> Frequency Chart
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg p-4 shadow-sm mb-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Filters</h3>
            
            <form method="GET" action="{{ route('grafik-asesmen.sum-chart') }}">
                <!-- First Row - 4 filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Division Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Division</label>
                        <select name="division" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="toggleDeptFilter(this.value)">
                            <option value="">All Divisions</option>
                            @foreach($divisions as $divisionKey => $divisionDepts)
                                <option value="{{ $divisionKey }}" {{ ($filters['division'] ?? '') == $divisionKey ? 'selected' : '' }}>
                                    Division {{ $divisionKey }} ({{ implode(', ', $divisionDepts) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Department Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                        <select name="dept" id="deptFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" {{ ($filters['division'] ?? false) ? 'disabled' : '' }}>
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->dept }}" {{ ($filters['dept'] ?? '') == $department->dept ? 'selected' : '' }}>
                                    {{ $department->dept }}
                                </option>
                            @endforeach
                        </select>
                        @if($filters['division'] ?? false)
                            <p class="text-xs text-gray-500 mt-1">Disabled when Division selected</p>
                        @endif
                    </div>

                    <!-- Panel Sadap Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Panel Sadap</label>
                        <select name="panel_sadap" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Panel Sadap</option>
                            @foreach($panelSadaps as $panelSadap)
                                <option value="{{ $panelSadap->panel_sadap }}" {{ ($filters['panel_sadap'] ?? '') == $panelSadap->panel_sadap ? 'selected' : '' }}>
                                    {{ $panelSadap->panel_sadap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kemandoran Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kemandoran</label>
                        <select name="kemandoran" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Kemandoran</option>
                            @foreach($kemandorans as $kemandoran)
                                <option value="{{ $kemandoran->kemandoran }}" {{ ($filters['kemandoran'] ?? '') == $kemandoran->kemandoran ? 'selected' : '' }}>
                                    {{ $kemandoran->kemandoran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Second Row - 3 filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->status }}" {{ ($filters['status'] ?? '') == $status->status ? 'selected' : '' }}>
                                    {{ $status->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Date To Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex space-x-2 justify-start pt-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <i class="ri-filter-line mr-1"></i> Apply Filters
                    </button>
                    <a href="{{ route('grafik-asesmen.sum-chart') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        <i class="ri-restart-line mr-1"></i> Clear
                    </a>
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(array_filter($filters))
                <div class="mt-4 p-3 bg-blue-50 rounded-md">
                    <p class="text-sm font-medium text-blue-800 mb-2">Active Filters:</p>
                    <div class="flex flex-wrap gap-2">
                        @if($filters['division'] ?? false)
                            @php
                                $divisionDepts = $divisions[$filters['division']] ?? [];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                Division {{ $filters['division'] }} ({{ implode(', ', $divisionDepts) }})
                            </span>
                        @endif
                        @if(($filters['dept'] ?? false) && !($filters['division'] ?? false))
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                Dept: {{ $filters['dept'] }}
                            </span>
                        @endif
                        @if($filters['panel_sadap'] ?? false)
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                Panel Sadap: {{ $filters['panel_sadap'] }}
                            </span>
                        @endif
                        @if($filters['kemandoran'] ?? false)
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                Kemandoran: {{ $filters['kemandoran'] }}
                            </span>
                        @endif
                        @if($filters['status'] ?? false)
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                Status: {{ $filters['status'] }}
                            </span>
                        @endif
                        @if($filters['date_from'] ?? false)
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                From: {{ Carbon\Carbon::parse($filters['date_from'])->format('d M Y') }}
                            </span>
                        @endif
                        @if($filters['date_to'] ?? false)
                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                To: {{ Carbon\Carbon::parse($filters['date_to'])->format('d M Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Chart Container -->
        <div class="bg-white rounded-lg p-4 shadow-sm mb-6">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700">Item Sum Score Bar Chart</h3>
            </div>
            <div style="height: 500px;">
                <canvas id="itemSumChart"></canvas>
            </div>
        </div>

        <!-- Summary Table -->
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Detailed Sum Statistics</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-green-500 text-white">
                            <th class="px-4 py-2 text-left text-sm font-medium">No</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Item Code</th>
                            <th class="px-4 py-2 text-left text-sm font-medium">Description</th>
                            <th class="px-4 py-2 text-right text-sm font-medium">Total Sum</th>
                            <th class="px-4 py-2 text-right text-sm font-medium">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalSum = collect($itemSums)->sum('sum');
                        @endphp
                        @foreach($itemSums as $index => $item)
                            <tr class="border-b border-gray-200 {{ $loop->even ? 'bg-green-50' : 'bg-white' }}">
                                <td class="px-4 py-2 text-sm">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 text-sm font-medium">{{ $item['label'] }}</td>
                                <td class="px-4 py-2 text-sm">{{ $item['description'] }}</td>
                                <td class="px-4 py-2 text-sm text-right font-semibold">{{ number_format($item['sum']) }}</td>
                                <td class="px-4 py-2 text-sm text-right">
                                    {{ $totalSum > 0 ? number_format(($item['sum'] / $totalSum) * 100, 1) : '0' }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                                    'Sum Score: ' + context.parsed.y.toLocaleString(),
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
                            text: 'Sum Score',
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