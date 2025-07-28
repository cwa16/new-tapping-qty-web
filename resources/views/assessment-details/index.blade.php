<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('assessments.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Summary Assessment</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
        </div>
    </div>
    
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4">
        <div class="flex justify-end">
            <form method="GET" action="{{ route('assessment-details.index') }}" class="flex items-center space-x-2">
                <select name="dept" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Departments</option>
                    @foreach($departments as $item)
                        <option value="{{ $item->dept }}" {{ ($filters['dept'] ?? '') == $item->dept ? 'selected' : '' }}>
                            {{ $item->dept }}
                        </option>
                    @endforeach
                </select>
                
                <select name="kemandoran" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Kemandoran</option>
                    @foreach($kemandoran as $item)
                        <option value="{{ $item->kemandoran }}" {{ ($filters['kemandoran'] ?? '') == $item->kemandoran ? 'selected' : '' }}>
                            {{ $item->kemandoran }}
                        </option>
                    @endforeach
                </select>
                
                <select name="panel_sadap" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Panel Sadap</option>
                    @foreach($panelSadap as $item)
                        <option value="{{ $item->panel_sadap }}" {{ ($filters['panel_sadap'] ?? '') == $item->panel_sadap ? 'selected' : '' }}>
                            {{ $item->panel_sadap }}
                        </option>
                    @endforeach
                </select>
                
                <button type="submit" class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    Filter
                </button>
                
                @if(!empty($filters['dept']) || !empty($filters['kemandoran']) || !empty($filters['panel_sadap']))
                    <a href="{{ route('assessment-details.index') }}" class="px-2 py-1 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                        <i class="ri-refresh-line"></i>
                    </a>
                @endif
            </form>
        </div>
        <div class="overflow-x-auto mt-2">
            <table class="w-full bg-white rounded-lg shadow">
                <thead>
                    <tr class="bg-blue-500 text-white border border-gray-200">
                        <th class="px-4 py-3 text-center text-sm border border-gray-200" rowspan="2">No</th>
                        <th class="px-4 py-3 text-center text-sm border border-gray-200" rowspan="2">Dept</th>
                        <th class="px-4 py-3 text-center text-sm border border-gray-200" rowspan="2">Kemandoran</th>
                        <th class="px-4 py-3 text-center text-sm border border-gray-200" rowspan="2">Panel Sadap</th>
                        <th class="px-4 py-3 text-center text-sm border border-gray-200" colspan="5">Kelas Perawan</th>
                        <th class="px-4 py-3 text-center text-sm border border-gray-200" colspan="5">Kelas Pulihan</th>
                        <th class="px-4 py-3 text-center text-sm border border-gray-200" colspan="5">Kelas NTA</th>
                        <th class="px-4 py-3 text-center text-sm border border-gray-200" rowspan="2">Total</th>
                    </tr>
                    <tr class="bg-blue-500 text-white">
                        <th class="px-4 py-3 text-center border border-gray-200">1</th>
                        <th class="px-4 py-3 text-center border border-gray-200">2</th>
                        <th class="px-4 py-3 text-center border border-gray-200">3</th>
                        <th class="px-4 py-3 text-center border border-gray-200">4</th>
                        <th class="px-2 py-3 text-center border border-gray-200">NC</th>
                        <th class="px-4 py-3 text-center border border-gray-200">1</th>
                        <th class="px-4 py-3 text-center border border-gray-200">2</th>
                        <th class="px-4 py-3 text-center border border-gray-200">3</th>
                        <th class="px-4 py-3 text-center border border-gray-200">4</th>
                        <th class="px-2 py-3 text-center border border-gray-200">NC</th>
                        <th class="px-4 py-3 text-center border border-gray-200">1</th>
                        <th class="px-4 py-3 text-center border border-gray-200">2</th>
                        <th class="px-4 py-3 text-center border border-gray-200">3</th>
                        <th class="px-4 py-3 text-center border border-gray-200">4</th>
                        <th class="px-2 py-3 text-center border border-gray-200">NC</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($summaryByKemandoranPanel as $key => $data)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3 text-center text-gray-900 border border-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-center text-gray-700 border border-gray-200">{{ $data['dept'] ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-900 border border-gray-200">{{ $data['kemandoran'] }}</td>
                            <td class="px-4 py-3 text-center text-gray-700 border border-gray-200">{{ $data['panel_sadap'] }}</td>
                            
                            <!-- Kelas Perawan (1-4, NC) -->
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_1']) && $data['perawan_1'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => '1']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_1'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_2']) && $data['perawan_2'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => '2']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_2'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_3']) && $data['perawan_3'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => '3']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_3'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_4']) && $data['perawan_4'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => '4']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_4'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-2 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_NC']) && $data['perawan_NC'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => 'NC']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800 hover:bg-red-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_NC'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            
                            <!-- Kelas Pulihan (1-4, NC) -->
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_1']) && $data['pulihan_1'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => '1']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_1'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_2']) && $data['pulihan_2'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => '2']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_2'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_3']) && $data['pulihan_3'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => '3']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_3'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_4']) && $data['pulihan_4'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => '4']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_4'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-2 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_NC']) && $data['pulihan_NC'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => 'NC']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800 hover:bg-red-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_NC'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            
                            <!-- Kelas NTA (1-4, NC) -->
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_1']) && $data['nta_1'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => '1']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer">
                                        {{ $data['nta_1'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_2']) && $data['nta_2'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => '2']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer">
                                        {{ $data['nta_2'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_3']) && $data['nta_3'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => '3']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer">
                                        {{ $data['nta_3'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_4']) && $data['nta_4'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => '4']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer">
                                        {{ $data['nta_4'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-2 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_NC']) && $data['nta_NC'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => 'NC']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800 hover:bg-red-200 transition-colors cursor-pointer">
                                        {{ $data['nta_NC'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            
                            <!-- Total -->
                            <td class="px-4 py-3 text-center bg-blue-50 border border-gray-200">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-200 text-blue-900">
                                    {{ $data['grand_total'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="20" class="px-4 py-8 text-center text-gray-500">
                                <i class="ri-inbox-line text-4xl mb-2"></i>
                                <p>No assessment data available</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                
                <!-- Summary Row -->
                @if(count($summaryByKemandoranPanel) > 0)
                    @php
                        $totals = [
                            'perawan' => ['1' => 0, '2' => 0, '3' => 0, '4' => 0, 'NC' => 0],
                            'pulihan' => ['1' => 0, '2' => 0, '3' => 0, '4' => 0, 'NC' => 0],
                            'nta' => ['1' => 0, '2' => 0, '3' => 0, '4' => 0, 'NC' => 0],
                            'grand_total' => 0
                        ];
                        
                        foreach($summaryByKemandoranPanel as $data) {
                            // Kelas Perawan totals - using flat structure
                            $totals['perawan']['1'] += $data['perawan_1'] ?? 0;
                            $totals['perawan']['2'] += $data['perawan_2'] ?? 0;
                            $totals['perawan']['3'] += $data['perawan_3'] ?? 0;
                            $totals['perawan']['4'] += $data['perawan_4'] ?? 0;
                            $totals['perawan']['NC'] += $data['perawan_NC'] ?? 0;
                            
                            // Kelas Pulihan totals - using flat structure
                            $totals['pulihan']['1'] += $data['pulihan_1'] ?? 0;
                            $totals['pulihan']['2'] += $data['pulihan_2'] ?? 0;
                            $totals['pulihan']['3'] += $data['pulihan_3'] ?? 0;
                            $totals['pulihan']['4'] += $data['pulihan_4'] ?? 0;
                            $totals['pulihan']['NC'] += $data['pulihan_NC'] ?? 0;
                            
                            // Kelas NTA totals - using flat structure
                            $totals['nta']['1'] += $data['nta_1'] ?? 0;
                            $totals['nta']['2'] += $data['nta_2'] ?? 0;
                            $totals['nta']['3'] += $data['nta_3'] ?? 0;
                            $totals['nta']['4'] += $data['nta_4'] ?? 0;
                            $totals['nta']['NC'] += $data['nta_NC'] ?? 0;
                            
                            $totals['grand_total'] += $data['grand_total'];
                        }
                    @endphp
                    <tfoot>
                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="4" class="px-4 py-3 text-center text-gray-900 border border-gray-200">TOTAL</td>
                            
                            <!-- Kelas Perawan Totals -->
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['perawan']['1'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['perawan']['2'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['perawan']['3'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['perawan']['4'] }}</td>
                            <td class="px-2 py-3 text-center border border-gray-200">{{ $totals['perawan']['NC'] }}</td>
                            
                            <!-- Kelas Pulihan Totals -->
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['pulihan']['1'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['pulihan']['2'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['pulihan']['3'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['pulihan']['4'] }}</td>
                            <td class="px-2 py-3 text-center border border-gray-200">{{ $totals['pulihan']['NC'] }}</td>
                            
                            <!-- Kelas NTA Totals -->
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['nta']['1'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['nta']['2'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['nta']['3'] }}</td>
                            <td class="px-4 py-3 text-center border border-gray-200">{{ $totals['nta']['4'] }}</td>
                            <td class="px-2 py-3 text-center border border-gray-200">{{ $totals['nta']['NC'] }}</td>
                            
                            <!-- Grand Total -->
                            <td class="px-4 py-3 text-center bg-blue-100 font-bold border border-gray-200">
                                {{ $totals['grand_total'] }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
    
    <script>
        // Initialize tooltips
        tippy('[data-tippy-content]', {
            theme: 'light',
            placement: 'top',
            arrow: true,
            animation: 'fade',
            delay: [100, 50]
        });
    </script>
</x-app-layout>