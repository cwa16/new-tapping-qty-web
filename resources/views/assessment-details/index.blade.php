<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('assessments.index') }}">
                <span class="text-xl font-bold text-gray-500 hover:text-gray-600">{{ $title }}</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
        </div>
    </div>
    
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4">
        <div class="flex justify-end">
            <form method="GET" action="{{ route('assessment-details.index') }}" class="flex items-center space-x-2">
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
                
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    Filter
                </button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded-lg shadow">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="px-4 py-3 text-left text-sm font-medium">Kemandoran</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Panel Sadap</th>
                        <th class="px-4 py-3 text-center text-sm font-medium">
                            <span data-tippy-content="Score: 0 - 10.9">Class 1</span>
                        </th>
                        <th class="px-4 py-3 text-center text-sm font-medium">
                            <span data-tippy-content="Score: 11 - 20.9">Class 2</span>
                        </th>
                        <th class="px-4 py-3 text-center text-sm font-medium">
                            <span data-tippy-content="Score: 21 - 26.9">Class 3</span>
                        </th>
                        <th class="px-4 py-3 text-center text-sm font-medium">
                            <span data-tippy-content="Score: 27 - 32.9">Class 4</span>
                        </th>
                        <th class="px-4 py-3 text-center text-sm font-medium">
                            <span data-tippy-content="Score: > 33">No Class</span>
                        </th>
                        <th class="px-4 py-3 text-center text-sm font-medium bg-blue-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($summaryByKemandoranPanel as $key => $data)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $data['kemandoran'] }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $data['panel_sadap'] }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    {{ $data['class_1'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $data['class_1'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    {{ $data['class_2'] > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $data['class_2'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    {{ $data['class_3'] > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $data['class_3'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    {{ $data['class_4'] > 0 ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $data['class_4'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    {{ $data['no_class'] > 0 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $data['no_class'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center bg-blue-50">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-200 text-blue-900">
                                    {{ $data['total'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                <i class="ri-inbox-line text-4xl mb-2"></i>
                                <p>No assessment data available</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                
                <!-- Summary Row -->
                @if(count($summaryByKemandoranPanel) > 0)
                    <tfoot>
                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="2" class="px-4 py-3 text-gray-900">TOTAL</td>
                            <td class="px-4 py-3 text-center">
                                {{ array_sum(array_column($summaryByKemandoranPanel, 'class_1')) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ array_sum(array_column($summaryByKemandoranPanel, 'class_2')) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ array_sum(array_column($summaryByKemandoranPanel, 'class_3')) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ array_sum(array_column($summaryByKemandoranPanel, 'class_4')) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ array_sum(array_column($summaryByKemandoranPanel, 'no_class')) }}
                            </td>
                            <td class="px-4 py-3 text-center bg-blue-100 font-bold">
                                {{ array_sum(array_column($summaryByKemandoranPanel, 'total')) }}
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