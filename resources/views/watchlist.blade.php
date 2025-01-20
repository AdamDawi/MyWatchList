<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Watchlist</title>
</head>
<body>
@php use Carbon\Carbon; @endphp
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Your Watchlist</h1>

        <!-- Form to Add a New Movie to the Watchlist -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <form action="{{ route('watchlist.add') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Input for Movie Title -->
                    <input type="text" name="title" placeholder="Movie Title" required
                           class="border border-gray-300 rounded-lg p-2">

                    <!-- Input for Movie Poster URL -->
                    <input type="url" name="poster_url" placeholder="Poster URL (optional)"
                           class="border border-gray-300 rounded-lg p-2">

                    <!-- Input for Movie Release Date (optional) -->
                    <input type="date" name="release_date" placeholder="Release Date (optional)"
                           class="border border-gray-300 rounded-lg p-2">

                    <!-- Input for Backdrop Path (optional) -->
                    <input type="url" name="backdrop_path" placeholder="Backdrop Path (optional)"
                           class="border border-gray-300 rounded-lg p-2">

                    <!-- Input for Vote Average (optional) -->
                    <input type="number" step="0.01" name="vote_average" placeholder="Vote Average (optional)"
                           min="0" max="10"
                           class="border border-gray-300 rounded-lg p-2">

                    <!-- Submit Button to Add Movie -->
                    <button type="submit"
                            class="bg-blue-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-600">
                        Add Movie
                    </button>
                </div>
            </form>
        </div>



        <!-- Display the Movie List or a Placeholder if Empty -->
        @if($movies == null || $movies->isEmpty())
            <!-- Message for an Empty Watchlist -->
            <p class="text-center text-gray-600">Your watchlist is empty. Start adding some movies!</p>
        @else
            <!-- Grid to Display Movies -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <!-- Movie Poster -->
                        <div
                            class="relative w-full h-64 flex justify-center items-center bg-gray-100">
                            <img src="{{ $movie->poster_url }}"
                                 alt="{{ $movie->title }}"
                                 class="absolute inset-0 w-full h-64 object-cover"
                                 onerror="this.onerror=null; this.src='/images/no_image_placeholder.png'; this.className='h-32 object-contain bg-gray-100';">
                        </div>

                        <!-- Movie Details -->
                        <div class="p-4">
                            <div class="flex items-center justify-center">
                                <!-- Movie Title -->
                                <h2 class="text-lg font-semibold align-middle">{{ $movie->title }}</h2>
                            </div>

                            <!-- Release Date -->
                            <p class="text-gray-600 text-sm text-center">
                                <strong>Release Date:</strong>
                                {{ $movie->release_date ? Carbon::parse($movie->release_date)->format('Y') : 'N/A' }}
                            </p>

                            <!-- Vote Average -->
                            <p class="text-gray-600 text-sm text-center">
                                <strong>Rating:</strong>
                                {{ $movie->vote_average !== null ? number_format($movie->vote_average, 1) . ' / 10' : 'N/A' }}
                            </p>

                            <!-- Display Note -->
                            <div id="note-display-{{ $movie->id }}">
                                @if($movie->note != "" && $movie->note != null)
                                    <p class="text-gray-600 text-sm text-center">
                                        <strong>Note:</strong>
                                    </p>
                                @endif
                                <span id="note-text-{{ $movie->id }}">
                                {{ $movie->note }}
                            </span>
                            </div>

                            <!-- Form to Edit Note -->
                            <form action="{{ route('watchlist.update', $movie->id) }}" method="POST"
                                  class="mt-4 text-center" id="edit-note-form-{{ $movie->id }}" style="display:none;">
                                @csrf
                                @method('PATCH')
                                <textarea name="note" rows="3" placeholder="Add a note..."
                                          class="w-full border rounded-lg p-2" id="note-textarea-{{ $movie->id }}"
                                          required>{{ $movie->note }}</textarea>
                                <!-- Save Button -->
                                <button type="submit"
                                        class="mt-2 bg-green-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-green-600 w-full">
                                    Save Note
                                </button>
                                <!-- Cancel Button -->
                                <button type="button"
                                        class="mt-2 bg-gray-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-gray-600 w-full"
                                        onclick="toggleEditForm({{ $movie->id }})">
                                    Cancel
                                </button>
                            </form>

                            <!-- Edit Note Button -->
                            <button type="button"
                                    class="mt-2 bg-yellow-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-yellow-600 w-full"
                                    id="edit-btn-{{ $movie->id }}"
                                    style="background-color: #FBBF24;"
                                    onclick="toggleEditForm({{ $movie->id }})">
                                Edit Note
                            </button>

                            <!-- Remove Movie Button -->
                            <form id="remove-btn-{{ $movie->id }}"
                                  action="{{ route('watchlist.remove', $movie->id) }}" method="POST"
                                  class="mt-4 text-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-red-600 w-full">
                                    Remove
                                </button>
                            </form>

                            <!-- Read More Button -->
                            <form id="readmore-btn-{{ $movie->id }}"
                                  action="{{ route('movie.details', $movie->id) }}" method="GET"
                                  class="mt-4 text-center">
                                @csrf
                                <button type="submit"
                                        class="bg-blue-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-600 w-full">
                                    Read More
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script>
        // Function to Toggle Note Editing Form Visibility
        function toggleEditForm(movieId) {
            var removeBtn = document.getElementById('remove-btn-' + movieId);
            var readMoreBtn = document.getElementById('readmore-btn-' + movieId);
            var editForm = document.getElementById('edit-note-form-' + movieId);
            var noteDisplay = document.getElementById('note-display-' + movieId);
            var editBtn = document.getElementById('edit-btn-' + movieId);

            if (editForm.style.display === 'none' || editForm.style.display === '') {
                noteDisplay.style.display = 'none';
                editForm.style.display = 'block';
                editBtn.style.display = 'none';
                removeBtn.style.display = 'none';
                readMoreBtn.style.display = 'none';
            } else {
                noteDisplay.style.display = 'block';
                editForm.style.display = 'none';
                editBtn.style.display = 'block';
                removeBtn.style.display = 'block';
                readMoreBtn.style.display = 'block';
            }
        }
    </script>
</x-app-layout>
</body>
</html>
