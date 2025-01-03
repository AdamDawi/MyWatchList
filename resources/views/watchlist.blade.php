@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Watchlist</title>
    <!-- CDN FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<x-app-layout>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Your Watchlist</h1>

        <!-- Add Movie Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <form action="{{ route('watchlist.add') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <input type="text" name="title" placeholder="Movie Title" required
                           class="border border-gray-300 rounded-lg p-2">
                    <input type="url" name="poster_url" placeholder="Poster URL" required
                           class="border border-gray-300 rounded-lg p-2">
                    <button type="submit"
                            class="bg-blue-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-600">
                        Add Movie
                    </button>
                </div>
            </form>
        </div>

        <!-- Movie List -->
        @if($movies == null || $movies->isEmpty())
            <p class="text-center text-gray-600">Your watchlist is empty. Start adding some movies!</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div
                            class="relative w-full h-64 flex justify-center items-center bg-gray-100 border-2 border-dashed border-gray-400">
                            <img src="{{ $movie->poster_url }}"
                                 alt="{{ $movie->title }}"
                                 class="w-full h-64 object-cover"
                                 onerror="this.onerror=null; this.src='/images/no_image_placeholder.png'; this.className='h-32 object-contain bg-gray-100 border-2 border-dashed border-gray-400';">
                        </div>

                        <div class="p-4">
                            <div class="flex items-center justify-center">
                                <h2 class="text-lg font-semibold">{{ $movie->title }}  </h2>
                                <div class="px-1"></div>
                                <a href="{{ route('movie.details', $movie->id) }}"
                                   class="px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">
                                    <i class="fas fa-info"></i>
                                </a>
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

                            <!-- Notatka -->
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

                            <!-- Formularz edytowania notatki -->
                            <form action="{{ route('watchlist.update', $movie->id) }}" method="POST"
                                  class="mt-4 text-center" id="edit-note-form-{{ $movie->id }}" style="display:none;">
                                @csrf
                                @method('PATCH')
                                <textarea name="note" rows="3" placeholder="Add a note..."
                                          class="w-full border rounded-lg p-2" id="note-textarea-{{ $movie->id }}"
                                          required>{{ $movie->note }}</textarea>
                                <button type="submit"
                                        class="mt-2 bg-green-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-green-600 w-full">
                                    Save Note
                                </button>
                                <!-- Przycisk Cancel -->
                                <button type="button"
                                        class="mt-2 bg-gray-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-gray-600 w-full"
                                        onclick="toggleEditForm({{ $movie->id }})">
                                    Cancel
                                </button>
                            </form>

                            <!-- Przycisk Edytuj -->
                            <button type="button"
                                    class="mt-2 bg-yellow-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-yellow-600 w-full "
                                    style="background-color: #FBBF24;"
                                    id="edit-btn-{{ $movie->id }}"
                                    onclick="toggleEditForm({{ $movie->id }})">
                                Edit
                            </button>

                            <!-- Przycisk Remove -->
                            <form
                                id="remove-btn-{{ $movie->id }}"
                                action="{{ route('watchlist.remove', $movie->id) }}" method="POST"
                                class="mt-4 text-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-red-600 w-full">
                                    Remove
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script>
        // Funkcja do przełączania widoczności notatki i formularza edycji
        function toggleEditForm(movieId) {
            var removeBtn = document.getElementById('remove-btn-' + movieId);
            var editForm = document.getElementById('edit-note-form-' + movieId);
            var noteDisplay = document.getElementById('note-display-' + movieId);
            var editBtn = document.getElementById('edit-btn-' + movieId);

            if (editForm.style.display === 'none' || editForm.style.display === '') {
                // Ukryj tekst i pokaż textarea
                noteDisplay.style.display = 'none';
                editForm.style.display = 'block';
                editBtn.style.display = 'none'; // Ukryj przycisk po edytowaniu
                removeBtn.style.display = 'none'; // Ukryj przycisk po edytowaniu
            } else {
                // Ukryj textarea i pokaż tekst
                noteDisplay.style.display = 'block';
                editForm.style.display = 'none';
                editBtn.style.display = 'block'; // Pokaż przycisk po zapisaniu
                removeBtn.style.display = 'block'; // Pokaż przycisk po zapisaniu
            }
        }
    </script>
</x-app-layout>
</body>
</html>
