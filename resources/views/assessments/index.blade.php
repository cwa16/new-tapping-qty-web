<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('assessments.index') }}">
                <span class="text-xl font-bold text-gray-500 hover:text-gray-600">{{ $title }}</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
        </div>
        <a href="" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="ri-add-line"></i> New Assessment
        </a>
    </div>
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-2">
        <div class="p-2 flex justify-end">
            <form action="{{ route('assessments.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by Name" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <!-- Preserve other filters when searching -->
                <input type="hidden" name="department" value="{{ $filters['department'] ?? '' }}">
                <input type="hidden" name="block" value="{{ $filters['blok'] ?? '' }}">
                <input type="hidden" name="kemandoran" value="{{ $filters['kemandoran'] ?? '' }}">
                <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="ri-search-line text-white text-sm"></i>
                </button>
            </form>
        </div>
        <div class="flex items-center justify-end">
            <form action="{{ route('assessments.index') }}" method="GET" class="flex items-center space-x-2">
                <!-- Preserve search when filtering -->
                <input type="hidden" name="search" value="{{ $filters['search'] ?? '' }}">
                
                <select name="department" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->dept }}" {{ ($filters['department'] ?? '') == $dept->dept ? 'selected' : '' }}>
                            {{ $dept->dept }}
                        </option>
                    @endforeach
                </select>
                
                <select name="blok" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Blocks</option>
                    @foreach($bloks as $blok)
                        <option value="{{ $blok->blok }}" {{ ($filters['blok'] ?? '') == $blok->blok ? 'selected' : '' }}>
                            {{ $blok->blok }}
                        </option>
                    @endforeach
                </select>
                
                <select name="kemandoran" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Kemandoran</option>
                    @foreach($kemandoran as $kmd)
                        <option value="{{ $kmd->kemandoran }}" {{ ($filters['kemandoran'] ?? '') == $kmd->kemandoran ? 'selected' : '' }}>
                            {{ $kmd->kemandoran }}
                        </option>
                    @endforeach
                </select>
                
                <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="ri-filter-line text-white text-sm"></i>
                </button>
                
                <!-- Clear filters button -->
                <a href="{{ route('assessments.index') }}" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                    <i class="ri-refresh-line text-white text-sm"></i>
                </a>
            </form>
        </div>
        <div class="p-1 overflow-x-auto mt-2">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="px-4 py-0.5 text-left text-sm font-medium">No.</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Tanggal Inspeksi</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Dept</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">NIK Penyadap</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Nama Penyadap</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Kemandoran</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Task</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Panel Sadap</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Status Kulit</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Luka kayu kecil (BO) / Tidak Mengunakan Gagang Panjang (HO)" class="">1.1</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Luka kayu sedang (BO)/Tidak Menggunakan Pisau sodhok(HO)" class="">1.2</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Luka kayu besar (BO)/Sadapan Tidak Disodhok (HO)" class="">1.3</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Kedalaman sadap (normatif)" class="">2.1</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Kedalaman sadap (kurang)" class="">2.2</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Kedalaman sadap (terlalu dalam)" class="">2.3</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Irisan melampaui batas depan" class="">3.1</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Irisan melampaui batas belakang" class="">3.2</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Tidak ada sodokan" class="">3.3</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Tidak ada pethikan (V)" class="">3.4</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Tebal Tatal > 2mm (BO)/ >3mm(HO)" class="">3.5</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Bergelombang" class="">3.6</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Tidak ada tanda bulan" class="">3.7</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Sudut sadap > 30°(BO)/45° (HO)" class="">4.1</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Sudut sadap < 30°(BO)/45° (HO)" class="">4.2</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Pengambilan scrap Diambil" class="">5.1</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Pengambilan scrap Tidak Diambil" class="">5.2</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Peralatan tidak lengkap Talang" class="">6.1</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Peralatan tidak lengkap mangkok" class="">6.2</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Peralatan tidak lengkap Hanger" class="">6.3</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Kebersihan alat Talang" class="">7.1</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Kebersihan alat Mangkok" class="">7.2</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Kebersihan alat Ember" class="">7.3</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Pohon sehat tidak disadap" class="">8</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Hasil tidak dipungut" class="">9</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">
                            <span data-tippy-content="Talang sadap mepet" class="">10</span>
                        </th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Nilai</th>
                        <th class="px-4 py-0.5 text-left text-sm font-medium">Kelas</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($assessments as $assessment)
                        <tr class="border-b border-gray-200 {{ $loop->even ? 'bg-blue-100' : 'bg-white' }}">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ Carbon\Carbon::parse($assessment->tgl_inspeksi)->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ $assessment->dept }}</td>
                            <td class="px-4 py-2">{{ $assessment->nik_penyadap }}</td>
                            <td class="px-4 py-2">{{ $assessment->nama_penyadap }}</td>
                            <td class="px-4 py-2">{{ $assessment->status }}</td>
                            <td class="px-4 py-2">{{ $assessment->kemandoran }}</td>
                            <td class="px-4 py-2">{{ $assessment->task }}</td>
                            <td class="px-4 py-2">{{ $assessment->panel_sadap }}</td>
                            <td class="px-4 py-2">{{ $assessment->jenis_kulit_pohon }}</td>
                            <td class="px-4 py-2">{{ $assessment->item1_1 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item1_2 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item1_3 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item2_1 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item2_2 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item2_3 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item3_1 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item3_2 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item3_3 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item3_4 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item3_5 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item3_6 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item3_7 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item4_1 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item4_2 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item5_1 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item5_2 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item6_1 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item6_2 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item6_3 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item7_1 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item7_2 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item7_3 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item8 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item9 }}</td>
                            <td class="px-4 py-2">{{ $assessment->item10 }}</td>
                            <td class="px-4 py-2">{{ $assessment->nilai }}</td>
                            @if ($assessment->nilai >= 0 && $assessment->nilai <= 10.9)
                            <td class="px-4 py-2">1</td>
                            @elseif ($assessment->nilai > 10 && $assessment->nilai <= 20.9)
                            <td class="px-4 py-2">2</td>
                            @elseif ($assessment->nilai > 20.9 && $assessment->nilai <= 26.9)
                            <td class="px-4 py-2">3</td>
                            @elseif($assessment->nilai > 26 && $assessment->nilai <= 32.9)
                            <td class="px-4 py-2">4</td>
                            @else
                            <td class="px-4 py-2">No Class</td>
                            @endif

                        </tr>
                            
                        @endforeach

                    
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
<script>
    tippy('[data-tippy-content]', {
            theme: 'light',
            placement: 'top',
            arrow: true,
            animation: 'fade',
            delay: [100, 50]
        });
</script>