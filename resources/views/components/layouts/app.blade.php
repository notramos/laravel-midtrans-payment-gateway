<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'CV.AXEL DIGITAL CREATIVE' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom styles for loading overlay and modal */
     
    </style>
</head>
<body class="bg-gray-100">
    @include('components.navbar')
    <div class="container mx-auto p-6">
        @yield('content')
    </div>
    @yield('scripts') {{-- Pastikan ini ada --}}
</body>
</html> 