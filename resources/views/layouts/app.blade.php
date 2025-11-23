<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page' }}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="h-full">

    {{-- Header (No Menu, No Navigation) --}}
    <header class="bg-white shadow py-4">
        <div class="max-w-5xl mx-auto px-4">
            <h1 class="text-xl font-bold">
                {{ $header ?? 'Page Title' }}
            </h1>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="max-w-5xl mx-auto mt-8 px-4">
        <div class="bg-white p-6 rounded-lg shadow">
            @yield('content')
        </div>
    </main>

</body>
</html>
