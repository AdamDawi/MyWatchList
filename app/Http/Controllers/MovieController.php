<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query', '');

        // Return an empty result set if the query is blank
        if (empty($query)) {
            return response()->json(['movies' => []]);
        }

        // API URL and headers
        $apiUrl = 'https://api.themoviedb.org/3/search/movie';
        $apiKey = config('services.tmdb.api_key');

        try {
            // Header wymagany przez api
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'Authorization' => "Bearer $apiKey",
            ])->get($apiUrl, [
                'query' => $query,
                'include_adult' => false,
                'language' => 'en-US',
                'page' => 1,
            ]);

            if ($response->ok()) {
                $movies = $response->json()['results'];
                return response()->json(['movies' => $movies]);
            }

            return response()->json(['error' => 'API Error'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function addFromSearch(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'poster_url' => 'required|url'
            ]);

            auth()->user()->movies()->create($validated);

        }catch (\Exception $e) {
            // Zwrócenie odpowiedzi JSON
            $errorMessage = $e->getMessage();
            return response()->json(['success' => false, 'message' => $errorMessage]);
        }

        // Zwrócenie odpowiedzi JSON
        return response()->json(['success' => true, 'message' => 'Movie added to your watchlist!']);
    }

}
