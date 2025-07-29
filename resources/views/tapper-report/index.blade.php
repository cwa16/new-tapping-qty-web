<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('tapper-report.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Tapper Report</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
        </div>
    </div>

    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4">
        <!-- Filter Section -->
        <div class="mb-4 bg-white rounded-lg p-4 shadow-sm">
            <form action="{{ route('tapper-report.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search Tapper</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                           placeholder="Name or NIK" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select name="departemen" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->departemen }}" {{ ($filters['departemen'] ?? '') == $dept->departemen ? 'selected' : '' }}>
                                {{ $dept->departemen }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- <!-- Kemandoran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kemandoran</label>
                    <select name="kemandoran" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Kemandoran</option>
                        @foreach($kemandorans as $kemandoran)
                            <option value="{{ $kemandoran->kemandoran }}" {{ ($filters['kemandoran'] ?? '') == $kemandoran->kemandoran ? 'selected' : '' }}>
                                {{ $kemandoran->kemandoran }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}

                <!-- Filter Buttons -->
                <div class="flex space-x-2 items-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                        <i class="ri-filter-line mr-1"></i>
                        Filter
                    </button>
                    
                    @if(!empty($filters['search']) || !empty($filters['departemen']) || !empty($filters['kemandoran']))
                        <a href="{{ route('tapper-report.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                            <i class="ri-refresh-line mr-1"></i>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- <!-- Summary -->
        @if($tappers->count() > 0)
            <div class="mb-4 bg-blue-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-blue-900">
                        Found {{ $tappers->total() }} Tappers
                    </h3>
                    <div class="text-sm text-blue-700">
                        Total Assessments: {{ $tappers->sum('total_assessments') }}
                    </div>
                </div>
            </div>
        @endif --}}

        <!-- Results Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">NIK</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Nama Penyadap</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Department</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Kemandoran</th>
                            <th class="px-4 py-3 text-center text-sm font-medium">Total Assessments</th>
                            <th class="px-4 py-3 text-center text-sm font-medium">Last Assessment</th>
                            <th class="px-4 py-3 text-center text-sm font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tappers as $tapper)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm">
                                    {{ ($tappers->currentPage() - 1) * $tappers->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium">{{ $tapper->nik }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $tapper->name }}</td>
                                <td class="px-4 py-3 text-sm">{{ $tapper->departemen }}</td>
                                <td class="px-4 py-3 text-sm">{{ $tapper->kemandoran }}</td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $tapper->total_assessments }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    @if($tapper->last_assessment)
                                        {{ \Carbon\Carbon::parse($tapper->last_assessment)->format('d M Y') }}
                                    @else
                                        <span class="text-gray-400">No assessments</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <a href="{{ route('tapper-report.detail', $tapper->nik) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 text-xs">
                                        <i class="ri-eye-line mr-1"></i>
                                        View History
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    <i class="ri-search-line text-4xl text-gray-300 mb-2"></i>
                                    <p>No tappers found matching your criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($tappers->hasPages())
            <div class="mt-4">
                <div class="pagination-wrapper">
                    {{ $tappers->appends(request()->query())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>