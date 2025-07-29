<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('assessment-details.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Summary Assessment</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
            <span class="text-base font-light text-gray-500 hover:text-gray-600">Detail</span>
        </div>
    </div>
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-4">
        <div class="">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="px-2 py-1 font-normal">No</th>
                        <th style="width: 12%" class="px-2 py-1 font-normal text-left">Tanggal Inspeksi</th>
                        <th class="px-2 py-1 font-normal">Dept</th>
                        <th class="px-2 py-1 font-normal text-left">Kemandoran</th>
                        <th class="px-2 py-1 font-normal text-left">NIK Penyadap</th>
                        <th class="px-2 py-1 font-normal text-left">Nama Penyadap</th>
                        <th class="px-2 py-1 font-normal text-left">Panel Sadap</th>
                        <th class="px-2 py-1 font-normal">Nilai</th>
                        <th class="px-2 py-1 font-normal">Kelas</th>
                    </tr>
                </thead>
                </thead>
                <tbody>
                    @foreach ($assessments as $item)
                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} border-b border-gray-200">
                        <td class="px-2 py-0.5 text-center">{{ $loop->iteration }}</td>
                        <td class="px-2 py-0.5">{{ \Carbon\Carbon::parse($item->tgl_inspeksi)->format('d M Y') }}</td>
                        <td class="px-2 py-0.5 text-center">{{ $item->dept }}</td>
                        <td class="px-2 py-0.5">{{ $item->kemandoran }}</td>
                        <td class="px-2 py-0.5">{{ $item->nik_penyadap }}</td>
                        <td class="px-2 py-0.5">{{ $item->nama_penyadap }}</td>
                        <td class="px-2 py-0.5">{{ $item->panel_sadap }}</td>
                        <td class="px-2 py-0.5 text-center">{{ $item->nilai }}</td>
                        <td class="px-2 py-0.5 text-center">
                            @php
                                $kelasType = request()->query('kelas_type');
                                $kelas = '';
                                switch ($kelasType) {
                                    case 'perawan':
                                       $kelas = $item->kelas_perawan;
                                        break;
                                    case 'pulihan':
                                        $kelas = $item->kelas_pulihan;
                                        break;
                                    case 'nta':
                                        $kelas = $item->kelas_nta;
                                        break;
                                }
                            @endphp
                            {{ $kelas }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</x-app-layout>