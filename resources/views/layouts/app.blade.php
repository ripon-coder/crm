<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full flex flex-col bg-gray-50 dark:bg-gray-900">
    
    @include('layouts.navbar')

    {{-- Page Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    @include('layouts.footer')

</body>
</html>
