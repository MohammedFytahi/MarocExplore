<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'accommodation',
        'activities',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relation avec l'itinéraire
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
