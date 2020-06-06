<?php

namespace Tests\Unit\Http\Controllers\API\Owners;

use App\Owner;
use App\Animal;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnimalsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        // users
        $this->adminUser = factory(User::class)->create(['role' => 'admin']);
        $this->vetUser = factory(User::class)->create(['role' => 'vet']);

        // 1 owner in DB
        $this->owner_DB1 = factory(Owner::class)->create([
            "first_name" => "Test Owner DB 1", 
            "user_id" => 1
        ]);

        // 2 animals attached to that owner
        $this->animal_DB1 = factory(Animal::class)->create([
            "name" => "Test Animal DB 1", 
            "owner_id" => 1,
        ]);

        Animal::find(1)->setTreatments(["Test Treatment 1", "Test Treatment 2"]);

        $this->animal_DB2 = factory(Animal::class)->create([
            "name" => "Test Animal DB 2", 
            "owner_id" => 1
        ]);
        
        // animal data ready for a POST request
        $this->animal_data = factory(Animal::class)->make(
            ["name" => "Test Animal Data"
            ])->toArray();
        
        // add some treatments into post request data
        $this->animal_data["treatments"] = ["Test Treatment Data 1", "Test Treatment Data 2"];

        // animal data ready for a POST request - No Treatment Data
        $this->animal_data_2 = factory(Animal::class)->make(
            ["name" => "Test Animal Data 2"
            ])->toArray();
    }

    // Test all routes with No Authentication
    // Expected - Not Allowed - 401 Unauthorized
    public function testAllNoAuth() {
        // GET /owners/{owner}/animals
        // fake a GET request, need to include headers so we don't redirect to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('GET', '/api/owners/1/animals');
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

        // POST /owners/{owner}/animals
        // fake a POST request, need to include headers so we don't redirect to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('POST', '/api/owners/1/animals');
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();
    }

    // Test show route with Vet
    // Expected - Allowed - 2 Animals returned w/ treatments
    public function testShowVet()
    {
        // act as the vet user
        $this->actingAs($this->vetUser, 'api');

        // fake a GET request
        $response = $this->call('GET', '/api/owners/1/animals')->getOriginalContent();

        // check we get back two animals that are in the DB from setup
        $this->assertSame(2, $response->count());

        // check we get back the first treatment
        $this->assertSame("Test Treatment 1", $response->get(0)->treatments->get(0)->name);
    }    

    // Test show route with Admin
    // Expected - Allowed - 2 Animals returned w/ treatments
    public function testShowAdmin()
    {
        // act as the admin user
        $this->actingAs($this->adminUser, 'api');

        // fake a GET request
        $response = $this->call('GET', '/api/owners/1/animals')->getOriginalContent();

        // check we get back two animals that are in the DB from setup
        $this->assertSame(2, $response->count());

        // check we get back the first treatment
        $this->assertSame("Test Treatment 1", $response->get(0)->treatments->get(0)->name);
    }    

    // Test POST route with Vet
    // Expected - Not Allowed - 403 - not authorized
    public function testStoreVet()
    {
        // act as the vet user
        $this->actingAs($this->vetUser, 'api');
      
        // fake post request with animal info
        $response = $this->withHeaders(["Accept" => "application/json"])->json('POST', '/api/owners/1/animals', $this->animal_data);

        // check we get back 403 - not authorized
        $response->assertStatus(403);
    }

    // Test POST route with Admin
    // Expected - Allowed - New 3rd Animal added to the owner with treatments
    public function testStoreAdmin()
    {
        // act as the vet user
        $this->actingAs($this->adminUser, 'api');
      
        // fake post request with animal info
        $response = $this->call('POST', '/api/owners/1/animals', $this->animal_data);

        // check we have 3 animals in the DB now
        $animal_DB = Animal::all();

        $this->assertSame(3, $animal_DB->count());

        // check name matches
        $this->assertSame("Test Animal Data", $animal_DB->last()->name);

        // check treatments were save appropriately
        $this->assertSame("Test Treatment Data 1", $animal_DB->last()->treatments->get(0)->name);

        // fake post request with animal info - animal with no treatments
        $response = $this->call('POST', '/api/owners/1/animals', $this->animal_data_2);

        $response->assertStatus(201);
        
        // check we have 4 animals in the DB now
        $animal_DB = Animal::all();

        $this->assertSame(4, $animal_DB->count());

        // check name matches
        $this->assertSame("Test Animal Data 2", $animal_DB->last()->name);


    }
}
