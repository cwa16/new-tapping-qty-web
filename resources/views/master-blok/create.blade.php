<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('master-blok.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Data Blok</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
                        <a href="{{ route('master-blok.create') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Tambah Data Blok</span>
            </a>
        </div>
    </div>
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-2">
        <form action="{{ route('master-blok.store') }}" method="POST">
            <div class="grid grid-cols-4 gap-x-2">
                @csrf
                <div class="p-0">
                    <label for="block_name" class="block text-sm font-medium text-gray-700">Nama Blok</label>
                    <input type="text" name="block_name" id="block_name" required class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Nama Blok">
                </div>
                <div class="p-0">
                    <label for="year_planting" class="block text-sm font-medium text-gray-700">Tahun Tanam</label>
                    <input type="text" name="year_planting" id="year_planting" required class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Tahun Tanam">
                </div>
                <div class="p-0">
                    <label for="clone" class="block text-sm font-medium text-gray-700">Clone</label>
                    <input type="text" name="clone" id="clone" required class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Clone">
                </div>
                <div class="p-0">
                    <label for="dept" class="block text-sm font-medium text-gray-700">Dept</label>
                    <select name="dept" id="dept" required class="mt-1 block w-full px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">-- Select Dept --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                    </select>

                </div>
            </div>
            <div class="mt-4 flex justify-center gap-x-2">
                <a href="{{ route('master-blok.index') }}">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Batal
                    </button>
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>