<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;

class DestinationController extends Controller
{
    public function store(Request $request, $itiniraireId)
    {
        $itiniraire = Itinerary::findOrFail($itiniraireId);
    
        // Validate the incoming destination data
        $request->validate([
            'destinations' => 'required|array',
            'destinations.*.name' => 'required|string',
            'destinations.*.accommodation' => 'required|string',
            'destinations.*.activities' => 'required|string',
        ]);
    
        // Retrieve the destinations to add
        $destinationsData = $request->input('destinations');
    
        // Create and attach the destinations to the itinerary
        $destinations = [];
        foreach ($destinationsData as $destinationData) {
            $destinations[] = [
                'name' => $destinationData['name'],
                'accommodation' => $destinationData['accommodation'],
                'activities' => $destinationData['activities']
            ];
        }
    
        // Associate destinations with the itinerary
        $itiniraire->destinations()->createMany($destinations);
    
        return response()->json(['message' => 'Destinations added successfully'], 200);
    }
    
    
}
