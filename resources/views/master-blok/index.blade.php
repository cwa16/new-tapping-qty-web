<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('master-blok.index') }}">
                <span class="text-base font-light text-gray-500 hover:text-gray-600">Data Blok</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
        </div>
        <a href="{{ route('master-blok.create') }}" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="ri-add-line"></i> New Blok
        </a>
    </div>
    <div class="mx-2 bg-gray-50 rounded-md shadow-md shadow-black/10 p-2">
        <div class="flex justify-end gap-x-2 mb-2">
            <form action="{{ route('master-blok.index') }}" method="GET">
                <input type="text" name="search" placeholder="Search..." class="px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button class="px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    <i class="ri-search-line"></i>
                </button>
            </form>
            <a href="{{ route('master-blok.index') }}">
                <button class="px-2 py-1 bg-gray-400 text-white rounded-md hover:bg-gray-600">
                    <i class="ri-refresh-line"></i>
                </button>
            </a>
        </div>
        <div class="p-0 flex justify-center">
            <table class="w-[600px] table-auto border-collapse">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="px-2 py-1">No</th>
                        <th class="px-2 py-1">Kode Blok</th>
                        <th class="px-2 py-1">Nama Blok</th>
                        <th class="px-2 py-1">Clone</th>
                        <th class="px-2 py-1">YP</th>
                        <th class="px-2 py-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blocks as $item)
                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="px-2 py-0.5 border border-gray-300">{{ ($blocks->currentPage() - 1) * $blocks->perPage() + $loop->iteration }}</td>
                        <td class="px-2 py-0.5 border border-gray-300">{{ $item->block_code }}</td>
                        <td class="px-2 py-0.5 border border-gray-300">{{ $item->block_name }}</td>
                        <td class="px-2 py-0.5 border border-gray-300">{{ $item->clone }}</td>
                        <td class="px-2 py-0.5 border border-gray-300">{{ $item->year_planting }}</td>
                        <td class="px-2 py-0.5 border border-gray-300">
                            <div class="flex gap-x-2 justify-center">
                                <a href="{{ route('master-blok.edit', $item->id) }}" class="px-2 py-0.5 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <button type="button" class="px-2 py-0.5 bg-red-500 text-white rounded hover:bg-red-600 delete-btn" 
                                        data-id="{{ $item->id }}" 
                                        data-name="{{ $item->block_name }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                            

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($blocks->hasPages())
            <div class="mt-4 px-4">
                <div class="pagination-wrapper">
                    {{ $blocks->appends(request()->query())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96 mx-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <i class="ri-error-warning-line text-red-500 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Delete</h3>
                    <p class="text-sm text-gray-500">This action cannot be undone.</p>
                </div>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-gray-700">
                    Are you sure you want to delete the block "<span id="deleteBlockName" class="font-semibold"></span>"?
                </p>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors"
                        onclick="closeDeleteModal()">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                        <i class="ri-delete-bin-line mr-1"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentDeleteId = null;

        // Open delete modal
        function openDeleteModal(id, name) {
            currentDeleteId = id;
            document.getElementById('deleteBlockName').textContent = name;
            document.getElementById('deleteForm').action = `{{ route('master-blok.index') }}/${id}`;
            document.getElementById('deleteModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Close delete modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            document.body.style.overflow = '';
            currentDeleteId = null;
        }

        // Add event listeners to delete buttons
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    openDeleteModal(id, name);
                });
            });

            // Close modal when clicking outside
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && currentDeleteId !== null) {
                    closeDeleteModal();
                }
            });
        });
    </script>
</x-app-layout>