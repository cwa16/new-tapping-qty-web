<x-app-layout :title="$title">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 mx-2">
        <!-- Total Assessment This Week Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-700">Total Assessment This Week</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">24</p>
                    <p class="text-sm text-gray-500 mt-1">This Week Assessments</p>
                </div>
                <div class="flex-shrink-0">
                    <i class="ri-bar-chart-2-fill text-3xl text-blue-500"></i>
                </div>
            </div>
        </div>

        <!-- Total Assessments Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-700">Total Assessments</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">156</p>
                    <p class="text-sm text-gray-500 mt-1">All time assessments</p>
                </div>
                <div class="flex-shrink-0">
                    <i class="ri-file-list-3-line text-3xl text-green-500"></i>
                </div>
            </div>
        </div>

        <!-- Total Penyadap Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-700">Total Tappers</h3>
                    <p class="text-3xl font-bold text-purple-600 mt-2">42</p>
                    <p class="text-sm text-gray-500 mt-1">Active tappers</p>
                </div>
                <div class="flex-shrink-0">
                    <i class="ri-group-line text-3xl text-purple-500"></i>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>