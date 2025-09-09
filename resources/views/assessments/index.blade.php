<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('assessments.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Data Asesmen</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
        </div>
        <button onclick="openUploadModal()" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="ri-add-line"></i> Upload Data
        </button>
    </div>
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-2">
        <div class="p-2 flex justify-between items-center">
            <form action="{{ route('assessments.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by Name"
                    class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <!-- Preserve other filters when searching -->
                <input type="hidden" name="department" value="{{ $filters['department'] ?? '' }}">
                <input type="hidden" name="blok" value="{{ $filters['blok'] ?? '' }}">
                <input type="hidden" name="kemandoran" value="{{ $filters['kemandoran'] ?? '' }}">
                <input type="hidden" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
                <input type="hidden" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="ri-search-line text-white text-sm"></i>
                </button>
            </form>
            <div class="p-0 flex items-center space-x-2">
                <form action="{{ route('assessments.index') }}" method="GET" class="flex items-center space-x-2">
                    <!-- Filter Modal Button -->
                    <button type="button" onclick="openFilterModal()"
                        class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <i class="ri-filter-line text-white text-sm"></i>
                    </button>
                </form>
                {{-- Clear Filter Button --}}
                <form action="{{ route('assessments.index') }}" method="GET" class="flex items-center space-x-2">
                    <button type="submit" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                        <i class="ri-restart-line text-white text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="p-1 overflow-x-auto mt-2">
            <div class="overflow-x-auto w-full rounded-lg shadow-xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            {{-- Add 'border-r border-blue-500' to each <th> element --}}
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                No.</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Tanggal Inspeksi</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Dept</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                NIK Penyadap</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Nama Penyadap</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Status</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Kemandoran</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Blok</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Task</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Panel Sadap</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Status Kulit</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                1.1</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                1.2</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                1.3</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                2.1</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                2.2</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                2.3</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                3.1</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                3.2</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                3.3</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                3.4</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                3.5</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                3.6</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                3.7</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                4.1</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                4.2</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                5.1</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                5.2</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                6.1</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                6.2</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                6.3</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                7.1</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                7.2</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                7.3</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                8</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                9</th>
                            <th
                                class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                10</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Nilai</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Kelas Perawan</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap border-r border-blue-500">
                                Kelas Pulihan</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Kelas NTA</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($assessments as $assessment)
                            <tr
                                class="{{ $loop->even ? 'bg-blue-100' : 'bg-white' }} hover:bg-blue-50 transition duration-150">
                                {{-- Add 'border-r border-gray-200' to each <td> element --}}
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ ($assessments->currentPage() - 1) * $assessments->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ Carbon\Carbon::parse($assessment->tgl_inspeksi)->format('d M Y') }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->dept }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->nik_penyadap }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->nama_penyadap }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->status }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->kemandoran }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->blok }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->task }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->panel_sadap }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->jenis_kulit_pohon }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item1_1 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item1_2 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item1_3 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item2_1 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item2_2 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item2_3 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item3_1 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item3_2 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item3_3 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item3_4 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item3_5 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item3_6 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item3_7 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item4_1 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item4_2 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item5_1 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item5_2 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item6_1 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item6_2 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item6_3 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item7_1 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item7_2 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item7_3 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item8 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item9 }}</td>
                                <td
                                    class="px-3 py-2 text-center whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->item10 }}</td>
                                <td
                                    class="px-3 py-2 whitespace-nowrap text-sm font-bold text-gray-800 border-r border-gray-200">
                                    {{ $assessment->nilai }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->kelas_perawan }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 border-r border-gray-200">
                                    {{ $assessment->kelas_pulihan }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800">
                                    {{ $assessment->kelas_nta }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Links -->
        @if ($assessments->hasPages())
            <div class="mt-4 px-4">
                <div class="pagination-wrapper">
                    {{ $assessments->appends(request()->query())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        style="display: none;">
        <div class="bg-white border border-gray-300 rounded-lg shadow-lg p-6 w-[600px] mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Filter Data Assessments</h3>
                <button onclick="closeFilterModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <form action="{{ route('assessments.index') }}" method="GET">
                <!-- Preserve search when filtering -->
                <input type="hidden" name="search" value="{{ $filters['search'] ?? '' }}">

                <div class="grid grid-cols-2 gap-4">
                    <!-- Department Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Department:</label>
                        <select name="department"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Departments</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->dept }}"
                                    {{ ($filters['department'] ?? '') == $dept->dept ? 'selected' : '' }}>
                                    {{ $dept->dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Block Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Block:</label>
                        <select name="blok"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Blocks</option>
                            @foreach ($bloks as $blok)
                                <option value="{{ $blok->blok }}"
                                    {{ ($filters['blok'] ?? '') == $blok->blok ? 'selected' : '' }}>
                                    {{ $blok->blok }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kemandoran Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kemandoran:</label>
                        <select name="kemandoran"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Kemandoran</option>
                            @foreach ($kemandoran as $kmd)
                                <option value="{{ $kmd->kemandoran }}"
                                    {{ ($filters['kemandoran'] ?? '') == $kmd->kemandoran ? 'selected' : '' }}>
                                    {{ $kmd->kemandoran }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Empty div for spacing -->
                    <div></div>

                    <!-- Date From Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date:</label>
                        <input type="date" name="date_from" id="dateFrom"
                            value="{{ $filters['date_from'] ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Date To Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date:</label>
                        <input type="date" name="date_to" id="dateTo" value="{{ $filters['date_to'] ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <div>
                        @if (
                            !empty($filters['department']) ||
                                !empty($filters['blok']) ||
                                !empty($filters['kemandoran']) ||
                                !empty($filters['date_from']) ||
                                !empty($filters['date_to']))
                            <a href="{{ route('assessments.index', ['search' => $filters['search'] ?? '']) }}"
                                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Clear All Filters
                            </a>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        <button type="button" onclick="closeFilterModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Upload Modal --}}

    <div id="uploadModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        style="display: none;">
        <div class="bg-white border border-gray-300 rounded-lg shadow-lg p-6 w-[600px] mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Upload Data Assessments</h3>
                <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>
            <!-- Upload form goes here -->
            <form action="{{ route('assessment.import-form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Select File:</label>
                    <input type="file" name="file" id="file" accept=".xlsx, .xls, .csv" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeUploadModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Upload</button>
                </div>
            </form>
            <a href="{{ route('assessment.download-template') }}"
                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                Download Format
            </a>
        </div>
    </div>
</x-app-layout>

<script>
    // Tippy.js tooltips
    // tippy('[data-tippy-content]', {
    //         theme: 'light',
    //         placement: 'top',
    //         arrow: true,
    //         animation: 'fade',
    //         delay: [100, 50]
    //     });

    // Filter modal functions
    function openFilterModal() {
        document.getElementById('filterModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeFilterModal() {
        document.getElementById('filterModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Upload modal functions
    function openUploadModal() {
        document.getElementById('uploadModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('filterModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeFilterModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFilterModal();
        }
    });
</script>
