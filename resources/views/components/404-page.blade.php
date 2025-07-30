<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center">
            <!-- 404 Number -->
            <h1 class="text-9xl font-bold text-blue-600 mb-4">404</h1>
            
            <!-- Message -->
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Page Not Found</h2>
            <p class="text-gray-600 mb-8">Sorry, the page you are looking for doesn't exist.</p>
            
            <!-- Back Button -->
            <button onclick="history.back()" 
                    class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                <i class="ri-arrow-left-line mr-2"></i>
                Go Back
            </button>
        </div>
    </div>
</body>
</html>