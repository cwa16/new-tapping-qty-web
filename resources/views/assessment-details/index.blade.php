<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('assessment-details.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Summary Assessment</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
        </div>
    </div>
    
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4">
        <div class="bg-white p-2 rounded-lg mb-4 shadow-md shadow-black/10">
            <p class="text-lg font-medium text-gray-900 my-2">Filters</p>
            <form method="GET" action="{{ route('assessment-details.index') }}">
                <div class="grid grid-cols-5 items-center gap-x-2">
                    <div class="">
                         <label class="block text-sm font-medium text-gray-700 mb-1">Dept</label>
                        <select name="dept" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <option value="">All Departments</option>
                            @foreach($departments as $item)
                                <option value="{{ $item->dept }}" {{ ($filters['dept'] ?? '') == $item->dept ? 'selected' : '' }}>
                                    {{ $item->dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kemandoran</label>
                        <select name="kemandoran" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <option value="">All Kemandoran</option>
                            @foreach($kemandoran as $item)
                                <option value="{{ $item->kemandoran }}" {{ ($filters['kemandoran'] ?? '') == $item->kemandoran ? 'selected' : '' }}>
                                    {{ $item->kemandoran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Panel Sadap</label>
                        <select name="panel_sadap" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <option value="">All Panel Sadap</option>
                            @foreach($panelSadap as $item)
                                <option value="{{ $item->panel_sadap }}" {{ ($filters['panel_sadap'] ?? '') == $item->panel_sadap ? 'selected' : '' }}>
                                    {{ $item->panel_sadap }}
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
                <div class="mt-2 flex gap-x-2">
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Filter
                    </button>
                    
                    @if(!empty($filters['dept']) || !empty($filters['kemandoran']) || !empty($filters['panel_sadap']) || !empty($filters['date_from']) || !empty($filters['date_to']))
                        <a href="{{ route('assessment-details.index') }}" class="px-3 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                            <i class="ri-refresh-line"></i>
                        </a>
                    @endif
                </div>
            </form>

        </div>

        <!-- Active Filters Display -->
        @if(!empty($filters['dept']) || !empty($filters['kemandoran']) || !empty($filters['panel_sadap']) || !empty($filters['date_from']) || !empty($filters['date_to']))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="ri-filter-line text-blue-600"></i>
                        <span class="text-sm font-medium text-blue-800">Active Filters:</span>
                        <div class="flex flex-wrap gap-2">
                            @if(!empty($filters['dept']))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Dept: {{ $filters['dept'] }}
                                    <a href="{{ route('assessment-details.index', array_merge($filters, ['dept' => ''])) }}" class="ml-1 text-blue-600 hover:text-blue-800">
                                        <i class="ri-close-line text-sm"></i>
                                    </a>
                                </span>
                            @endif
                            @if(!empty($filters['kemandoran']))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Kemandoran: {{ $filters['kemandoran'] }}
                                    <a href="{{ route('assessment-details.index', array_merge($filters, ['kemandoran' => ''])) }}" class="ml-1 text-blue-600 hover:text-blue-800">
                                        <i class="ri-close-line text-sm"></i>
                                    </a>
                                </span>
                            @endif
                            @if(!empty($filters['panel_sadap']))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Panel: {{ $filters['panel_sadap'] }}
                                    <a href="{{ route('assessment-details.index', array_merge($filters, ['panel_sadap' => ''])) }}" class="ml-1 text-blue-600 hover:text-blue-800">
                                        <i class="ri-close-line text-sm"></i>
                                    </a>
                                </span>
                            @endif
                            @if(!empty($filters['date_from']))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    From: {{ \Carbon\Carbon::parse($filters['date_from'])->format('d M Y') }}
                                    <a href="{{ route('assessment-details.index', array_merge($filters, ['date_from' => ''])) }}" class="ml-1 text-blue-600 hover:text-blue-800">
                                        <i class="ri-close-line text-sm"></i>
                                    </a>
                                </span>
                            @endif
                            @if(!empty($filters['date_to']))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    To: {{ \Carbon\Carbon::parse($filters['date_to'])->format('d M Y') }}
                                    <a href="{{ route('assessment-details.index', array_merge($filters, ['date_to' => ''])) }}" class="ml-1 text-blue-600 hover:text-blue-800">
                                        <i class="ri-close-line text-sm"></i>
                                    </a>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Results Summary -->
        {{-- <div class="flex justify-between items-center mt-4 mb-2">
            <div class="text-sm text-gray-600">
                @if(!empty($filters['dept']) || !empty($filters['kemandoran']) || !empty($filters['panel_sadap']))
                    <i class="ri-filter-line text-blue-600"></i>
                    <span class="font-medium">Filtered Results:</span> {{ count($summaryByKemandoranPanel) }} records
                @else
                    <span class="font-medium">Total Results:</span> {{ count($summaryByKemandoranPanel) }} records
                @endif
            </div>
            @if(!empty($filters['dept']) || !empty($filters['kemandoran']) || !empty($filters['panel_sadap']))
                <div class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded">
                    Totals below reflect filtered data only
                </div>
            @endif
        </div> --}}
        
        <div class="overflow-x-auto mt-2 rounded-lg shadow-md">
            <table class="w-full">
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
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => '1', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_1'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_2']) && $data['perawan_2'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => '2', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_2'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_3']) && $data['perawan_3'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => '3', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_3'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_4']) && $data['perawan_4'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => '4', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors cursor-pointer">
                                        {{ $data['perawan_4'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-2 py-3 text-center border border-gray-200">
                                @if(isset($data['perawan_NC']) && $data['perawan_NC'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'perawan', 'kelas_value' => 'NC', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
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
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => '1', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_1'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_2']) && $data['pulihan_2'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => '2', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_2'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_3']) && $data['pulihan_3'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => '3', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_3'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_4']) && $data['pulihan_4'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => '4', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors cursor-pointer">
                                        {{ $data['pulihan_4'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-2 py-3 text-center border border-gray-200">
                                @if(isset($data['pulihan_NC']) && $data['pulihan_NC'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'pulihan', 'kelas_value' => 'NC', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
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
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => '1', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer">
                                        {{ $data['nta_1'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_2']) && $data['nta_2'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => '2', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer">
                                        {{ $data['nta_2'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_3']) && $data['nta_3'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => '3', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer">
                                        {{ $data['nta_3'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_4']) && $data['nta_4'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => '4', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
                                       class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors cursor-pointer">
                                        {{ $data['nta_4'] }}
                                    </a>
                                @else
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-2 py-3 text-center border border-gray-200">
                                @if(isset($data['nta_NC']) && $data['nta_NC'] > 0)
                                    <a href="{{ route('assessment-details.detail', ['kemandoran' => $data['kemandoran'], 'panel_sadap' => $data['panel_sadap'], 'kelas_type' => 'nta', 'kelas_value' => 'NC', 'date_from' => $filters['date_from'] ?? '', 'date_to' => $filters['date_to'] ?? '']) }}" 
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
                
                <!-- Summary Row - Only show when filters are applied -->
                @if(count($summaryByKemandoranPanel) > 0 && (!empty($filters['dept']) || !empty($filters['kemandoran']) || !empty($filters['panel_sadap'])))
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
                            <td colspan="4" class="px-4 py-3 text-center text-gray-900 border border-gray-200">
                                <span class="text-gray-900">TOTAL</span>
                                {{-- <i class="ri-filter-line text-blue-600 ml-1"></i> --}}
                            </td>
                            
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