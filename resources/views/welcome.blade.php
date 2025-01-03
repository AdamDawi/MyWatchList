<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MyWatchList</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Include Tailwind -->
    <style>
    </style>
</head>

<body class="bg-white text-gray-800 font-sans antialiased">
<x-app-layout>
    @auth
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-center mb-6">Search Movies</h1>
            <div>
                <input
                    id="searchInput"
                    type="text"
                    placeholder="Type a movie name..."
                    class="w-full p-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <div id="results" class="mt-4 bg-white rounded-lg shadow-lg"></div>
            </div>
        </div>
    @endauth

    @guest
        <div class="flex items-center justify-center h-screen bg-gray-50">
            <div class="text-center p-6 max-w-lg bg-white rounded-lg shadow-lg">
                <h1 class="text-2xl font-semibold text-gray-800 mb-4">Welcome to MyWatchList</h1>
                <p class="text-gray-600 mb-6">Sign in or register to access the full functionality of the site and
                    manage your watchlist.</p>
                <div class="space-x-4">
                    <a href="{{ route('login') }}"
                       class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Sign In</a>
                    <a href="{{ route('register') }}"
                       class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Register</a>
                </div>
            </div>
        </div>
    @endguest

</x-app-layout>
<footer class="bg-gray-100 text-center py-4 w-full">
    <p class="text-gray-600">© 2025 MyWatchList. Adam Dawidziuk.</p>
</footer>
<script>
    const searchInput = document.getElementById('searchInput');
    const resultsDiv = document.getElementById('results');

    let debounceTimeout;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();

        // Clear the previous timeout
        clearTimeout(debounceTimeout);

        // Set a new debounce timeout
        debounceTimeout = setTimeout(async () => {
            if (!query) {
                resultsDiv.innerHTML = '';
                return;
            }

            try {
                const response = await fetch(`/movies/search?query=${encodeURIComponent(query)}`);
                const data = await response.json();

                if (data.error) {
                    resultsDiv.innerHTML = '<p class="p-4 text-red-500">Error fetching results. Please try again.</p>';
                    return;
                }

                displayResults(data.movies);
            } catch (error) {
                console.error('Error:', error);
                resultsDiv.innerHTML = '<p class="p-4 text-red-500">Error fetching results. Please try again.</p>';
            }
        }, 500);
    });

    function displayResults(movies) {
        if (movies.length === 0) {
            resultsDiv.innerHTML = '<p class="p-4 text-gray-500">No results found.</p>';
            return;
        }

        resultsDiv.innerHTML = movies
            .map(movie => `<p class="p-4 py-2 border-b last:border-b-0">${movie.title}</p>`)
            .join('');
    }
</script>

</body>
</html>
