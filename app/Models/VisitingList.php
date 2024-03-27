<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitingList extends Model
{
    use HasFactory;
    protected $fillable = ['itinerary_id'];

   
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
