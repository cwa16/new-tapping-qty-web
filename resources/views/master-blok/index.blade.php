<x-app-layout :title="$title">
    <div class="mx-2 mb-2 flex items-center space-x-2 justify-between">
        <div class="items-center flex space-x-2">
            <a href="{{ route('master-blok.index') }}">
                <span class="text-xl font-bold text-gray-500 hover:text-gray-600">{{ $title }}</span>
            </a>
            <i class="ri-arrow-right-s-line text-2xl text-gray-400"></i>
        </div>
    </div>
</x-app-layout>