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
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between w-full">
            <!-- Edit Button -->
            <button type="button"
                    onclick="openModal({{ $movie->id }})"
                    class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 px-4 py-3 text-white rounded-lg font-medium transition">
                Edit
            </button>

            <!-- Remove Button -->
            <form
                id="remove-btn-{{ $movie->id }}"
                action="{{ route('watchlist.remove', $movie->id) }}" method="POST"
                class="w-full sm:w-auto text-center mt-4 sm:mt-0">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full sm:w-auto bg-red-500 hover:bg-red-600 px-4 py-3 text-white rounded-lg font-medium transition">
                    Remove
                </button>
            </form>
        </div>

        <!-- Modal -->
        <div id="edit-modal-{{ $movie->id }}" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-full sm:w-1/2 p-6 relative">
                <!-- Close Modal Button -->
                <button type="button"
                        onclick="closeModal({{ $movie->id }})"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                    &times;
                </button>

                <!-- Form -->
                <form action="{{ route('watchlist.update', $movie->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="grid gap-4">
                        <!-- Title -->
                        <input type="text" name="title" value="{{ $movie->title }}" required
                               class="border border-gray-300 rounded-lg p-2" placeholder="Movie Title">

                        <!-- Poster URL -->
                        <input type="url" name="poster_url" value="{{ $movie->poster_url }}"
                               class="border border-gray-300 rounded-lg p-2" placeholder="Poster URL">

                        <!-- Release Date -->
                        <input type="date" name="release_date" value="{{ $movie->release_date }}"
                               class="border border-gray-300 rounded-lg p-2" placeholder="Release Date">

                        <!-- Backdrop Path -->
                        <input type="url" name="backdrop_path" value="{{ $movie->backdrop_path }}"
                               class="border border-gray-300 rounded-lg p-2" placeholder="Backdrop Path">

                        <!-- Vote Average -->
                        <input type="number" step="0.01" name="vote_average" value="{{ $movie->vote_average }}"
                               class="border border-gray-300 rounded-lg p-2" placeholder="Vote Average (0-10)" min="0" max="10">

                        <!-- Submit Button -->
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<script>
    function openModal(movieId) {
        document.getElementById(`edit-modal-${movieId}`).classList.remove('hidden');
    }

    function closeModal(movieId) {
        document.getElementById(`edit-modal-${movieId}`).classList.add('hidden');
    }
</script>
</body>
</html>
