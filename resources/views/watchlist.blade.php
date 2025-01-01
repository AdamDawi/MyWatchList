<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Watchlist
        </h2>
    </x-slot>

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
                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold">{{ $movie->title }}</h2>
                            <form action="{{ route('watchlist.update', $movie->id) }}" method="POST" class="mt-4">
                                @csrf
                                @method('PATCH')
                                <textarea name="note" rows="3" placeholder="Add a note..." class="w-full border rounded-lg p-2"
                                          required>{{ $movie->note }}</textarea>
                                <button type="submit"
                                        class="mt-2 bg-green-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-green-600">
                                    Save Note
                                </button>
                            </form>
                            <form action="{{ route('watchlist.remove', $movie->id) }}" method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-red-600">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
