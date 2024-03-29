<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ItineraryController;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItineraryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method_creates_itinerary()
    {
        $this->withoutExceptionHandling(); 
        
        $requestData = [
            'title' => 'Test Itinerary',
            'category' => 'Test Category',
            'duration' => 5,
            
        ];

        $request = new Request($requestData);

        $controller = new ItineraryController();
        $response = $controller->store($request);

        $this->assertDatabaseHas('itineraries', [
            'title' => 'Test Itinerary',
            'category' => 'Test Category',
            'duration' => 5,
            
        ]);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function test_update_method_updates_itinerary()
    {
        $this->withoutExceptionHandling(); 

        
        $itinerary = Itinerary::factory()->create();

        
        $requestData = [
            'title' => 'Updated Itinerary',
            'category' => 'Updated Category',
            'duration' => 10,
        ];

        $request = new Request($requestData);

        $controller = new ItineraryController();
        $response = $controller->update($request, $itinerary->id);

        $this->assertDatabaseHas('itineraries', [
            'id' => $itinerary->id,
            'title' => 'Updated Itinerary',
            'category' => 'Updated Category',
            'duration' => 10,

        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_index_method_returns_all_itineraries()
    {
        $this->withoutExceptionHandling(); 


        Itinerary::factory()->count(3)->create();

        $controller = new ItineraryController();
        $response = $controller->index();

        $this->assertCount(3, $response->getData()->itineraries);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_filtre_method_filters_itineraries_by_category_and_duration()
    {
        $this->withoutExceptionHandling(); 

        
        $itinerary1 = Itinerary::factory()->create(['category' => 'Category A', 'duration' => 5]);
        $itinerary2 = Itinerary::factory()->create(['category' => 'Category B', 'duration' => 10]);
        $itinerary3 = Itinerary::factory()->create(['category' => 'Category A', 'duration' => 8]);


        $request = new Request(['category' => 'Category A']);
        $controller = new ItineraryController();
        $response = $controller->filtre($request);
        $itineraries = $response->getData()->data;

        $this->assertCount(2, $itineraries);
        $this->assertEquals('Category A', $itineraries[0]->category);
        $this->assertEquals('Category A', $itineraries[1]->category);

        
        $request = new Request(['duration' => 10]);
        $response = $controller->filtre($request);
        $itineraries = $response->getData()->data;

        $this->assertCount(1, $itineraries);
        $this->assertEquals(10, $itineraries[0]->duration);
    }

    
}

