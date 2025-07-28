<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Tapping Qty APP</title>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
/>
<!-- Tippy.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/themes/light.css" />
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<style>
    .pagination-wrapper nav {
        background-color: white;
    }
    
    .pagination-wrapper .flex {
        background-color: white !important;
    }
    
    .pagination-wrapper span,
    .pagination-wrapper a {
        background-color: white !important;
        color: #374151 !important;
        border-color: #d1d5db !important;
    }
    
    .pagination-wrapper a:hover {
        background-color: #f3f4f6 !important;
        color: #1f2937 !important;
    }
    
    .pagination-wrapper span[aria-current="page"] {
        background-color: #3b82f6 !important;
        color: white !important;
        border-color: #3b82f6 !important;
    }
    
    .pagination-wrapper .text-gray-500 {
        color: #6b7280 !important;
    }
</style>

<body class="text-gray-800 font-inter">
    <x-sidebar></x-sidebar>
    <div class="ml-64">
        <x-header></x-header>
    </div>
    <x-main-layout :title="$title">
        {{ $slot }}
    </x-main-layout>
</body>

 <!-- Tippy.js JavaScript -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
</html>