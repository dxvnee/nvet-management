<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <x-error-message />

    <div class="w-full h-screen bg-primaryUltraLight">
        <div class="flex h-full p-5">


            @include('layouts.sidebar')

            <div id="main-content" class="transform duration-300 ease-in-out h-full flex flex-col w-full overflow-y-auto">


                @include('components.main-topbar', ['title' => $header, 'subtle' => $subtle])

                <main class = "flex-1">
                    {{ $slot }}
                </main>

                <div class="mt-auto">

                    @include('components.main-bottombar', ['title' => $header])
                </div>
            </div>

        </div>
    </div>

    <x-loading-screen />

</body>

</html>
