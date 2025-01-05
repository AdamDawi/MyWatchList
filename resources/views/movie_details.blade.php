<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">
<div class="relative min-h-screen">
    <!-- Background Poster -->
    @if($movie->backdrop_url != null && $movie->backdrop_url!="")
    <div
        class="absolute inset-x-0 min-h-screen bg-cover bg-center opacity-10"
        style="background-image: url({{ $movie->backdrop_url }});">
    </div>
    @else
        <div
            class="absolute inset-x-0 min-h-screen bg-cover bg-center opacity-10"
            style="background-image: url({{ $movie->poster_url }});">
        </div>
    @endif

    <!-- Content Container -->
    <div class="relative max-w-xl lg:max-w-5xl xl:max-w-7xl mx-auto p-4 sm:p-6 bg-white bg-opacity-95 rounded-lg shadow-lg">
        <!-- Movie Header -->
        <div class="flex flex-col md:flex-row items-center md:items-start">
            <!-- Movie Poster -->
            <div class="w-full sm:w-64 sm:h-80 flex justify-center items-center bg-gray-100">
                <img
                    src="{{ $movie->poster_url }}"
                    alt="Movie Poster"
                    class="w-full sm:w-64 sm:h-80 object-cover rounded-lg shadow-md"
                    onerror="this.onerror=null; this.src='/images/no_image_placeholder.png'; this.className='w-24 h-36 object-contain';">
            </div>
            <!-- Movie Details -->
            <div class="mt-4 md:mt-0 md:ml-8 text-center md:text-left">
                <h1 class="text-2xl sm:text-4xl font-bold mb-2 py-4">
                    {{ $movie->title }}
                </h1>
                <p class="text-gray-600 text-sm mb-4">
                    Released: <span class="text-gray-900">{{ $movie->release_date ?: 'N/A' }}</span>
                </p>
                <p class="text-gray-600 text-sm mb-4">
                    Rating: <span class="text-gray-900">{{ $movie->vote_average ? $movie->vote_average . " / 10" : 'N/A' }}</span>
                </p>
                <p class="text-gray-600 text-sm mb-6">
                    Your Note: <span>
                        @if($movie->note != "" && $movie->note != null)
                            <span class="text-gray-900">{{ $movie->note }}</span>
                        @else
                            <span class="text-gray-400">You can write your note in watchlist screen!</span>
                        @endif
                    </span>
                </p>
            </div>
        </div>

        <!-- Movie Overview -->
        <div class="mt-6">
            <h2 class="text-xl sm:text-2xl font-semibold mb-4">Overview</h2>
            <p class="text-gray-700 leading-relaxed text-sm sm:text-base">
                @if($movie->overview != "" && $movie->overview != null)
                    {{ $movie->overview }}
                @else
                    This movie doesn't have overview.
                @endif
            </p>
        </div>

        <!-- User Section -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-end">
            <form
                id="remove-btn-{{ $movie->id }}"
                action="{{ route('watchlist.remove', $movie->id) }}" method="POST"
                class="w-full sm:w-auto text-center">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full sm:w-auto bg-red-500 hover:bg-red-600 px-4 py-3 text-white rounded-lg font-medium transition">
                    Remove
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
