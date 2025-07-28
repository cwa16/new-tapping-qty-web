<div class="fixed left-0 top-0 w-64 h-full bg-white shadow-md p-4 overflow-y-auto">
    <a href="" class="p-5 flex items-center space-x-2 text-gray-800 hover:text-gray-600 justify-center">
        <span class="font-bold text-lg">Tapping QTY APP</span>
    </a>
    <div class="flex items-center pb-0 border-b border-b-gray-600"></div>
    <ul class="mt-4 space-y-2">
        <li>
            <a href="{{ route('dashboard') }}" class="block px-4 py-1 text-gray-600 hover:bg-gray-200 rounded">
                <i class="ri-home-4-line mr-2 text-lg"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('assessments.index') }}" class="block px-4 py-1 text-gray-600 hover:bg-gray-200 rounded">
                <i class="ri-file-list-3-line mr-2 text-lg"></i>
                Assessments
            </a>
        </li>
        <li>
            <a href="{{ route('assessment-details.index') }}" class="block px-4 py-1 text-gray-600 hover:bg-gray-200 rounded">
                <i class="ri-database-line mr-2 text-lg"></i>
                Summary Assessments
            </a>
        </li>
        <li>
            <a href="{{ route('grafik-asesmen.index') }}" class="block px-4 py-1 text-gray-600 hover:bg-gray-200 rounded">
                <i class="ri-line-chart-line mr-2 text-lg"></i>
                Grafik Asesmen
            </a>
        </li>

        <!-- Data Master Section -->
        <li class="mt-4">
            <div class="px-4 py-0">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Data Master</h3>
            </div>
        </li>
        <li>
            <a href="{{ route('master-blok.index') }}" class="block px-4 py-1 text-gray-600 hover:bg-gray-200 rounded">
                <i class="ri-layout-masonry-line mr-2 text-lg"></i>
                Master Block
            </a>
        </li>

    </ul>
    
    <!-- User Profile Menu -->
    <div class="absolute bottom-4 left-4 right-4">
        <div class="bg-gray-50 rounded-lg p-3 shadow-md shadow-black/10">
            <div class="flex items-center space-x-3">
                <!-- User Info -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        John Doe
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        john.doe@example.com
                    </p>
                </div>
                
                <!-- Logout-->
                <div class="relative">
                    <div class="p-0">
                            <form method="POST" action="">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-1 py-1 text-sm text-red-600 hover:bg-red-50" data-tippy-content="Logout">
                                    <i class="ri-logout-box-line text-xl"></i>
                                </button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    tippy('[data-tippy-content]', {
            theme: 'light',
            placement: 'top',
            arrow: true,
            animation: 'fade',
            delay: [100, 50]
        });
</script>
