<?php

// ItineraryController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;

class ItineraryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'duration' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validation de l'image
        ]);

        $itinerary = new Itinerary();
        $itinerary->title = $request->title;
        $itinerary->category = $request->category;
        $itinerary->duration = $request->duration;

        if ($request->hasFile('image')) {
            $itinerary->storeImage($request->file('image'));
        }

        if (auth()->check()) {
            $itinerary->user_id = auth()->id();
        }

        $itinerary->save();

        return response()->json(['message' => 'Itinerary created successfully', 'data' => $itinerary], 201);
    }

  
 

    public function update(Request $request, $itiniraireId)
    {
        // Recherchez l'itinéraire à modifier
        $itinerary = Itinerary::findOrFail($itiniraireId);
    
        // Validez les données entrantes
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'duration' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Mettez à jour les propriétés de l'itinéraire avec les données validées
        $itinerary->title = $validatedData['title'];
        $itinerary->category = $validatedData['category'];
        $itinerary->duration = $validatedData['duration'];
    
        // Vérifiez si une nouvelle image est téléchargée
        if ($request->hasFile('image')) {
            // Si une nouvelle image est téléchargée, stockez-la et mettez à jour le chemin de l'image
            $itinerary->storeImage($request->file('image'));
        }
    
        // Enregistrez les modifications de l'itinéraire
        $itinerary->save();
    
        // Retournez une réponse indiquant que l'itinéraire a été mis à jour avec succès
        return response()->json(['message' => 'Itinerary updated successfully', 'data' => $itinerary], 200);
    }
    public function index()
{
    $itineraries = Itinerary::all();
    return response()->json(['itineraries' => $itineraries], 200);
}

// ItineraryController.php

public function filtre(Request $request)
{
    $query = Itinerary::query();

    // Filtrer par catégorie si le paramètre de requête 'category' est présent
    if ($request->has('category')) {
        $query->where('category', $request->category);
    }

    // Filtrer par durée si le paramètre de requête 'duration' est présent
    if ($request->has('duration')) {
        $query->where('duration', $request->duration);
    }

    // Récupérer les itinéraires filtrés
    $itineraries = $query->get();

    return response()->json(['data' => $itineraries], 200);
}


    
}

