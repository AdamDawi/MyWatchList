<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'poster_url',
        'note',
        'user_id',
        'release_date',
        'vote_average',
        'overview'
    ];
    // Relacja do użytkownika
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
