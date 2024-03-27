<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Models\VisitingList;

class VisitingListController extends Controller
{
    public function addToVisitingList(Request $request, $itineraryId)
    {
        // Vérifier si l'itinéraire existe
        $itinerary = Itinerary::find($itineraryId);
        if (!$itinerary) {
            return response()->json(['message' => 'Itinerary not found'], 404);
        }

        // Vérifier si l'itinéraire est déjà dans la liste à visiter
        if (VisitingList::where('itinerary_id', $itineraryId)->exists()) {
            return response()->json(['message' => 'Itinerary already in visiting list'], 400);
        }

        // Ajouter l'itinéraire à la liste à visiter
        $visitingList = new VisitingList();
        $visitingList->itinerary_id = $itineraryId;
        $visitingList->save();

        return response()->json(['message' => 'Itinerary added to visiting list successfully'], 200);
    }
}
