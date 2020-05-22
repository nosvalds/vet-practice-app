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
        // Acting as Admin User
        $adminUser = factory(User::class)->create(['role' => 'admin']);
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
        // acting as vet
        $vetUser = factory(User::class)->create(['role' => 'vet']);
        $this->actingAs($vetUser, 'api');
       
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
    // Expected - Not Allowed - 401 Unauthorized
    public function testIndexNoAuth()
    {  
        // create 2 animals
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);
        factory(Animal::class)->create(["owner_id" => 1]);
   
        // fake a GET request, need to include headers so we don't redirect to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('POST', '/api/animals');
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();
    }

    // Test storing an animal with Admin user role
    // Expected - Allowed
    public function testStoreAdmin()
    {
        // acting as Admin
        $adminUser = factory(User::class)->create(['role' => 'admin']);
        $this->actingAs($adminUser, 'api');

        // make some animal data
        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 1",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();

        // fake post request with animal info
        $response = $this->call('POST', '/api/animals', $animal_data)->getOriginalContent();
        
        // check we get back an animal with 2 treatments
        $this->assertSame("Animal 1",$response->name);
        $this->assertSame(2,$response->treatments->count());

        // check it's been added to the database
        $animal = Animal::all()->first();
        $this->assertSame("Animal 1", $animal->name);

    }

    // Test storing an animal with Vet user role
    // Expected - Not Allowed - 403 - not authorized
    public function testStoreVet()
    {
        // acting as vet
        $vetUser = factory(User::class)->create(['role' => 'vet']);
        $this->actingAs($vetUser, 'api');

        // make some animal data to post
        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 1",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();

        // fake post request with animal info
        $response = $this->call('POST', '/api/animals', $animal_data);
        
        // check we get back 403 - not authorized
        $response->assertStatus(403);

        // check it's not been added to the database
        $animal_DB = Animal::all()->first();
        $this->assertSame(null, $animal_DB);
    }

    // Test storing an animal with no authentication
    // Expected - Not Allowed - 401 response/not authorized
    public function testStoreNoAuth()
    {
        // make some animal data to post
        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 1",
            "owner_id" => 1,
            "treatments" => ["Neutering 2", "Spaying 2"],
            ])->toArray();

        // fake post request with animal info, including Accept header to ensure we don't get a redirect to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('POST', '/api/animals', $animal_data);
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

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
    // Expected - Not Allowed - 401 response/not authorized
    public function testShowNoAuth()
    {
        // create animal in DB
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a GET request w/ header so we don't redirect to the login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('GET', '/api/animals/1');

        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();
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

        // update some information with a fake PUT
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
    // Expected - Not Allowed - 403 - not authorized
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
    // Expected - Not Allowed - 401 response/not authorized
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

        // update some information with a PUT w/ headers so we don't get redirected to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('PUT', '/api/animals/1', $animal_data);
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();
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
        $response = $this->call('DELETE', '/api/animals/1');

        // check we get back 204 
        $response->assertStatus(204);

        // check it's been removed from the database
        $this->assertTrue(Animal::all()->isEmpty());
    }

    // Test deleting animal with Vet User Role
    // Expected - Not Allowed - 403 - not authorized
    public function testDestroyVet()
    {
        // act as Vet
        $vetUser = factory(User::class)->create(['role' => 'vet']);
        $this->actingAs($vetUser, 'api');

        // create an Animal
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a DELETE request for that Animal
        $response = $this->call('DELETE', '/api/animals/1');

        // check we get back 403 - not authorized
        $response->assertStatus(403);

        // check it has NOT been removed from the database
        $this->assertNotTrue(Animal::all()->isEmpty());
    }

    // Test deleting animal with no Auth
    // Expected - Not Allowed - 401 response/not authorized
    public function testDestroyNoAuth()
    {
        // create an Animal
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a DELETE request for that Animal w/ header so we aren't redirected to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('DELETE', '/api/animals/1');

        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

        // check it has NOT been removed from the database
        $this->assertNotTrue(Animal::all()->isEmpty());
    }
}
