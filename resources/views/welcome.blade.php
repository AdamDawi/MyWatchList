<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Ustawienie kodowania znaków i widoku responsywnego -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tytuł strony -->
    <title>MyWatchList</title>

    <!-- Czcionki i style -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800 font-sans antialiased">
<!-- Główny układ aplikacji -->
<x-app-layout>
    <!-- Sekcja dla zalogowanych użytkowników -->
    @auth
        <div class="max-w-3xl mx-auto px-4">
            <!-- Nagłówek wyszukiwarki -->
            <h1 class="py-4 text-3xl font-bold text-center mb-6">Search Movies</h1>

            <!-- Pole wyszukiwania i wyniki -->
            <div>
                <input
                    id="searchInput"
                    type="text"
                    placeholder="Type a movie name..."
                    class="w-full p-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <!-- Kontener na wyniki wyszukiwania -->
                <div id="results" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6"></div>
            </div>
        </div>
    @endauth

    <!-- Sekcja dla gości (niezalogowanych użytkowników) -->
    @guest
        <div class="flex items-center justify-center h-screen bg-gray-50">
            <div class="text-center p-6 max-w-lg bg-white rounded-lg shadow-lg">
                <h1 class="text-2xl font-semibold text-gray-800 mb-4">Welcome to MyWatchList</h1>
                <p class="text-gray-600 mb-6">Sign in or register to access the full functionality of the site and manage your watchlist.</p>

                <!-- Przyciski logowania i rejestracji -->
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Sign In</a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Register</a>
                </div>
            </div>
        </div>
    @endguest
</x-app-layout>

<!-- Stopka strony -->
<footer class="pt-8 pb-4 bg-gray-100 text-center w-full">
    <p class="text-gray-600">&copy; 2025 MyWatchList. Adam Dawidziuk.</p>
</footer>

<!-- Skrypt obsługujący wyszukiwanie filmów -->
<script>
    const searchInput = document.getElementById('searchInput');
    const resultsDiv = document.getElementById('results');
    let debounceTimeout;

    // Obsługa wpisywania w polu wyszukiwania (z debounce)
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();

        clearTimeout(debounceTimeout);

        debounceTimeout = setTimeout(async () => {
            // Jeśli pole jest puste, usuń wyniki
            if (!query) {
                resultsDiv.innerHTML = '';
                return;
            }

            try {
                // Wykonanie zapytania do API
                const response = await fetch(`/movies/search?query=${encodeURIComponent(query)}`);
                const data = await response.json();

                // Obsługa błędów w odpowiedzi
                if (data.error) {
                    resultsDiv.innerHTML = '<p class="p-4 text-red-500">Error fetching results. Please try again.</p>';
                    return;
                }

                // Wyświetlenie wyników wyszukiwania
                displayResults(data.movies);
            } catch (error) {
                console.error('Error:', error);
                resultsDiv.innerHTML = '<p class="p-4 text-red-500">Error fetching results. Please try again.</p>';
            }
        }, 500);
    });

    // Funkcja do escapowania znaków w stringach (dla bezpieczeństwa)
    function escapeString(str) {
        if (typeof str !== 'string') {
            return '';  // Zwraca pusty string, jeśli str nie jest stringiem
        }

        // Escapowanie znaków HTML
        str = str.replace(/[&<>"']/g, function (char) {
            const escapeMap = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": ' '
            };
            return escapeMap[char] || char;
        });
        return str;
    }

    // Funkcja do wyświetlania wyników wyszukiwania
    function displayResults(movies) {
        if (movies.length === 0) {
            resultsDiv.innerHTML = '<p class="p-4 text-gray-500">No results found.</p>';
            return;
        }

        // Generowanie HTML dla każdego filmu
        resultsDiv.innerHTML = movies.map(movie => `
                <div class="bg-gray-100 p-4 rounded-lg shadow-lg flex flex-col items-center">
                    <img src="https://image.tmdb.org/t/p/original${movie.poster_path}"
                        alt="${movie.title}"
                        class="w-32 h-48 object-cover mb-4 rounded"
                        onerror="this.onerror=null; this.src='https://www.cams-it.com/wp-content/uploads/2015/05/default-placeholder-150x200.png';">
                    <h2 class="text-lg font-bold text-center">${movie.title}</h2>
                    <p class="text-sm text-gray-600">Release Year: ${movie.release_date ? movie.release_date.slice(0, 4) : 'N/A'}</p>
                    <p class="text-sm text-gray-600">Rating: ${movie.vote_average || 'N/A'}</p>
                    <button
                        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition"
                        onclick="addToWatchlist('${escapeString(movie.title)}', '${movie.poster_path}', '${movie.backdrop_path}', '${movie.release_date}', '${movie.vote_average}', '${escapeString(movie.overview)}')"
                    >
                        Add to Watchlist
                    </button>
                </div>
            `).join('');
    }

    // Funkcja dodawania filmu do watchlisty
    async function addToWatchlist(title, poster_url, backdrop_path, release_date, vote_average, overview) {
        poster_url = "https://image.tmdb.org/t/p/original" + poster_url;
        backdrop_path = "https://image.tmdb.org/t/p/original" + backdrop_path;
        console.log(title)
        console.log(poster_url)
        try {
            // Wysłanie zapytania POST do API
            const response = await fetch('/movies/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({title, poster_url, backdrop_path, release_date, vote_average, overview})
            });

            const result = await response.json();

            // Powiadomienie użytkownika o powodzeniu lub błędzie
            if (result.success) {
                alert(`"${title}" has been added to your watchlist!`);
            } else {
                alert(result.message || 'Failed to add the movie to your watchlist. Please try again.');
            }
        } catch (error) {
            console.error('Error adding to watchlist:', error);
            alert('An error occurred while adding the movie to your watchlist.');
        }
    }
</script>
</body>
</html>
