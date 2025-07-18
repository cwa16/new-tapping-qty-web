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
            <form action="" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Search by NIK or Name" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="ri-search-line text-white text-sm"></i>
                </button>
            </form>
        </div>
        <div class="flex items-center justify-end">
            <form action="" method="GET" class="flex items-center space-x-2">
                <select name="department" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="date_desc">Dept</option>
                </select>
                <select name="blok" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="date_desc">Blok</option>
                </select>
                <select name="kemandoran" class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="date_desc">Kemandoran</option>
                </select>
                <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="ri-filter-line text-white text-sm"></i>
                </button>
            
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