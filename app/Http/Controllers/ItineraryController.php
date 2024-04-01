<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;

class ItineraryController extends Controller
{
    /**
 * Store a new itinerary.
 *
 * @OA\Post(
 *     path="/api/itineraries",
 *     summary="Store a new itinerary",
 *     tags={"Itineraries"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Itinerary details",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"title", "category", "duration", "image"},
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="duration",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary",
 *                     description="Image file for the itinerary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Itinerary created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Itinerary created successfully"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="duration",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Unauthorized."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="The given data was invalid."
 *             ),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 description="Validation errors",
 *                 example={
 *                     "title": {"The title field is required."},
 *                     "category": {"The category field is required."},
 *                     "duration": {"The duration field is required."},
 *                     "image": {"The image must be an image.", "The image may not be greater than 2048 kilobytes."}
 *                 }
 *             )
 *         )
 *     )
 * )
 */

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

    /**
     * Update an existing itinerary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $itiniraireId
     * @return \Illuminate\Http\Response
     */

     /**
 * Update an existing itinerary.
 *
 * @OA\Put(
 *     path="/api/itineraries/{itiniraireId}",
 *     summary="Update an existing itinerary",
 *     tags={"Itineraries"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="itiniraireId",
 *         in="path",
 *         description="ID of the itinerary to update",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Itinerary details",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"title", "category", "duration", "image"},
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="duration",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary",
 *                     description="Image file for the itinerary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Itinerary updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Itinerary updated successfully"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="duration",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Unauthorized."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="The given data was invalid."
 *             ),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 description="Validation errors",
 *                 example={
 *                     "title": {"The title field is required."},
 *                     "category": {"The category field is required."},
 *                     "duration": {"The duration field is required."},
 *                     "image": {"The image must be an image.", "The image may not be greater than 2048 kilobytes."}
 *                 }
 *             )
 *         )
 *     )
 * )
 */

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

    /**
     * Retrieve all itineraries.
     *
     * @return \Illuminate\Http\Response
     */
   /**
 * Retrieve all itineraries.
 *
 * @OA\Get(
 *     path="/api/itineraries",
 *     summary="Retrieve all itineraries",
 *     tags={"Itineraries"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all itineraries",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="duration",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Unauthorized."
 *             )
 *         )
 *     )
 * )
 */
public function index()
{
    $itineraries = Itinerary::all();
    return response()->json(['itineraries' => $itineraries], 200);
}


    /**
     * Filter itineraries based on category and duration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
