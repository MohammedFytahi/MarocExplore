<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'duration',
        'image',
    ];
    public function storeImage($image)
    {
        $this->image = $image->store('itinerary_images', 'public');
        $this->save();
    }

    // Relation avec les destinations
    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
