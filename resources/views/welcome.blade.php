<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MyWatchList</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Include Tailwind -->
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans antialiased">
<x-app-layout>
{{--<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-center">--}}
{{--    @if (Route::has('login'))--}}
{{--        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">--}}
{{--            @auth--}}
{{--                <a href="{{ url('/watchlist') }}" class="font-semibold text-black hover:text-gray-600">Watch List</a>--}}
{{--            @else--}}
{{--                <a href="{{ route('login') }}" class="font-semibold text-black hover:text-gray-600">Log in</a>--}}

{{--                @if (Route::has('register'))--}}
{{--                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-black hover:text-gray-600">Register</a>--}}
{{--                @endif--}}
{{--            @endauth--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</div>--}}



</x-app-layout>
<footer class="bg-gray-100 text-center py-4 w-full">
    <p class="text-gray-600">© 2025 MyWatchList. Adam Dawidziuk.</p>
</footer>
</body>
</html>
