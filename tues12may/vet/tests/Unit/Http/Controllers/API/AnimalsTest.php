<?php

namespace Tests\Unit\Http\Controllers\API;

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
        // user
        $user = factory(User::class)->create();
        // owner
        $owner = factory(Owner::class)->create(["user_id" => 1]);
        
    }

    // Test showing the index of Animals with the admin role user
    // Expected - Allowed
    public function testIndexAdmin()
    {
        $adminUser = factory(User::class)->create(['role' => 'admin']);
        // first acting as Admin
        $this->actingAs($adminUser, 'api');
       
        // create 2 animals
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);
        factory(Animal::class)->create(["owner_id" => 1]);
   
        // fake a GET request
        $response = $this->call('GET', '/api/animals')->getOriginalContent();

        // check we get back two Animals
        $this->assertSame(2, $response->count());

        // check we get back the first Animal first
        $this->assertSame("Animal 1", $response->get(0)->name);
    }

    // Test showing the index of Animals with the vet role user
    // Expected - Allowed
    public function testIndexVet()
    {
        $adminUser = factory(User::class)->create(['role' => 'vet']);
        // first acting as Admin
        $this->actingAs($adminUser, 'api');
       
        // create 2 animals
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);
        factory(Animal::class)->create(["owner_id" => 1]);
   
        // fake a GET request
        $response = $this->call('GET', '/api/animals')->getOriginalContent();

        // check we get back two Animals
        $this->assertSame(2, $response->count());

        // check we get back the first Animal first
        $this->assertSame("Animal 1", $response->get(0)->name);
    }

    // Test showing the index of Animals with No Authentication
    // Expected - Not Allowed
    public function testIndexNoAuth()
    {  
        // create 2 animals
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);
        factory(Animal::class)->create(["owner_id" => 1]);
   
        // fake a GET request
        $response = $this->call('GET', '/api/animals');
      
        // check we get back no 401 response/not authorized
        // Figure out how to Add Accept application/json into header to fix this
        $response->assertStatus(401);
    }

    // Test storing an animal with Admin user role
    // Expected - Allowed
    public function testStoreAdmin()
    {
        $adminUser = factory(User::class)->create(['role' => 'admin']);

        // first acting as Admin
        $this->actingAs($adminUser, 'api');

        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 1",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();

        $response = $this->call('POST', '/api/animals', $animal_data)->getOriginalContent();
        
        // check we get back an animal with 2 treatments
        $this->assertSame("Animal 1",$response->name);
        $this->assertSame(2,$response->treatments->count());

        // check it's been added to the database
        $animal = Animal::all()->first();
        $this->assertSame("Animal 1", $animal->name);

    }
    // Test storing an animal with Vet user role
    // Expected - Not Allowed
    public function testStoreVet()
    {
        $vetUser = factory(User::class)->create(['role' => 'vet']);

        // next acting as vet (should not work)
        $this->actingAs($vetUser, 'api');

        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 1",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();

        $response = $this->call('POST', '/api/animals', $animal_data);
        
        // check we get back 403 - not authorized
        $response->assertStatus(403);

        // check it's not been added to the database
        $animal_DB = Animal::all()->first();
        $this->assertSame(null, $animal_DB);
    }

    // Test storing an animal with no authentication
    // Expected - Not Allowed
    public function testStoreNoAuth()
    {
     
        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 1",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();

        $response = $this->call('POST', '/api/animals', $animal_data);
        
        // check we get back 403 - not authorized
        $response->assertStatus(302);

        // check it's not been added to the database
        $animal_DB = Animal::all()->first();
        $this->assertSame(null, $animal_DB);
    }

    // Test Showing a single animal with Admin User Role
    // Expected - Allowed
    public function testShowAdmin()
    {
        // act as Admin
        $adminUser = factory(User::class)->create(['role' => 'admin']);
        $this->actingAs($adminUser, 'api');

        // create animal in DB
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a GET request
        $response = $this->call('GET', '/api/animals/1')->getOriginalContent();

        // check we get back the Animal we created 
        $this->assertSame("Animal 1", $response->name);
    }

    // Test Showing a single animal with Vet User Role
    // Expected - Allowed
    public function testShowVet()
    {
        // acting as vet
        $vetUser = factory(User::class)->create(['role' => 'vet']);
        $this->actingAs($vetUser, 'api');

        // create animal in DB
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a GET request
        $response = $this->call('GET', '/api/animals/1')->getOriginalContent();

        // check we get back the Animal we created 
        $this->assertSame("Animal 1", $response->name);
    }

    // Test Showing a single animal with No Auth
    // Expected - Not Allowed
    public function testShowNoAuth()
    {
        // create animal in DB
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a GET request
        $response = $this->call('GET', '/api/animals/1');

        // check we get back 403 - not authorized
        $response->assertStatus(302);
    }

    // Test Updating animal with Admin User Role
    // Expected - Allowed
    public function testUpdateAdmin()
    {
        // act as Admin
        $adminUser = factory(User::class)->create(['role' => 'admin']);
        $this->actingAs($adminUser, 'api');
        
        // create animal in DB
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // create some new animal data
        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 2",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();
        // update some information with a PUT
        // fake a PUT request
        $response = $this->call('PUT', '/api/animals/1', $animal_data)->getOriginalContent();

        // check we get back the updated info
        $this->assertSame("Animal 2", $response->name);

        // check DB has updated info
        $animal = Animal::all()->first();
        $this->assertSame("Animal 2", $animal->name);

        // check we've not *added* a new animal
        $animals = Animal::all();
        $this->assertSame(1, $animal->count());
        $this->assertSame("Animal 2", $animals->first()->name);
        $this->assertSame(2, $animal->first()->treatments->count());

    }

    // Test Updating animal with Vet User Role
    // Expected - Not Allowed
    public function testUpdateVet()
    {
        // act as Admin
        $vetUser = factory(User::class)->create(['role' => 'vet']);
        $this->actingAs($vetUser, 'api');

        // create animal in DB
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // create some new animal data
        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 2",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();
        // update some information with a PUT
        // fake a PUT request
        $response = $this->call('PUT', '/api/animals/1', $animal_data);

        // check we get back 403 - not authorized
        $response->assertStatus(403);
    }

    // Test Updating animal with No Auth
    // Expected - Not Allowed
    public function testUpdateNoAuth()
    {
        // create animal in DB
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // create some new animal data
        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 2",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();
        // update some information with a PUT
        // fake a PUT request
        $response = $this->call('PUT', '/api/animals/1', $animal_data);

        // check we get back 403 - not authorized
        $response->assertStatus(302);
    }

    // Test deleting animal with Admin User Role
    // Expected - Allowed
    public function testDestroyAdmin()
    {
        // act as Admin
        $adminUser = factory(User::class)->create(['role' => 'admin']);
        $this->actingAs($adminUser, 'api');

        // create an Animal
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a DELETE request for that Animal
        $this->call('DELETE', '/api/animals/1');

        // check it's been removed from the database
        $this->assertTrue(Animal::all()->isEmpty());
    }

    // Test deleting animal with Vet User Role
    // Expected - Not Allowed
    public function testDestroyVet()
    {
        // act as Vet
        $vetUser = factory(User::class)->create(['role' => 'vet']);
        $this->actingAs($vetUser, 'api');

        // create an Animal
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a DELETE request for that Animal
        $this->call('DELETE', '/api/animals/1');

        // check it's been removed from the database
        $this->assertTrue(Animal::all()->isEmpty());
    }
}
