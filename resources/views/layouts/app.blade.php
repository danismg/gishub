<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- icon tabs --}}
    <link rel="icon" href="{{ asset('img/logo_gis.png') }}" />
    <title>
        GisHub | @yield('title')
    </title>
    {{-- <link href="{{ asset('css/output.css') }}" rel="stylesheet" /> --}}
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class=" min-h-screen flex flex-col">
    @include('layouts.navigation')

    <div class="flex-grow pt-16 lg:pt-8">
        @yield('content')
    </div>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
