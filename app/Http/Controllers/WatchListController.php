<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WatchListController extends Controller
{
    // Odczytanie listy
    public function index()
    {
        $movies = auth()->user()->watchlist; // Filmy użytkownika
        return view('watchlist', compact('movies'));
    }

    // Dodanie filmu do listy
    public function add(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'poster_url' => 'required|url',
        ]);

        auth()->user()->watchlist()->create($validated);
        return redirect()->route('watchlist')->with('success', 'Movie added to your watchlist!');
    }

    // Aktualizacja notatki
    public function update(Request $request, Movie $movie)
    {
        $this->authorize('update', $movie); // Tylko właściciel może edytować
        $validated = $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $movie->update($validated);
        return redirect()->route('watchlist')->with('success', 'Note updated!');
    }

    // Usunięcie filmu z listy
    public function remove(Movie $movie)
    {
        $this->authorize('delete', $movie); // Tylko właściciel może usuwać
        $movie->delete();
        return redirect()->route('watchlist')->with('success', 'Movie removed from your watchlist!');
    }
}
