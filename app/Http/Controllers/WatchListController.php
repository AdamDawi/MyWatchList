<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WatchListController extends Controller
{
    // Odczytanie listy
    public function index()
    {
        //ORM - Object-Relation Mapping
        $movies = auth()->user()->movies; // Filmy użytkownika
        return view('watchlist', compact('movies'));
    }

    // Dodanie filmu do listy
    public function add(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'poster_url' => 'required|url',
        ]);

        auth()->user()->movies()->create($validated);
        return redirect()->route('watchlist')->with('success', 'Movie added to your watchlist!');
    }

    //Aktualizacja notatki
    public function update(Request $request, Movie $movie)
    {
        // Sprawdzenie, czy użytkownik jest właścicielem filmu
        if (auth()->user()->id != $movie->user_id) {
            return back()->with('error', 'You are not authorized to edit this movie.');
        }

        // Walidacja danych
        $validated = $request->validate([
            'note' => 'required|string|max:500',
        ]);

        // Aktualizacja notatki
        $movie->update($validated);

        return redirect()->route('watchlist')->with('success', 'Note updated!');
    }

    // Usunięcie filmu z listy
    public function remove(Movie $movie)
    {
        // Sprawdzenie, czy zalogowany użytkownik jest właścicielem filmu
        if (auth()->user()->id != $movie->user_id) {
            return back()->with('error', 'You are not authorized to perform this action.');
        }

        // Usuń film
        if ($movie->delete()) {
            return redirect()->route('watchlist')->with('success', 'Movie removed from your watchlist!');
        }

        return back()->with('error', 'Failed to remove the movie.');
    }
}
