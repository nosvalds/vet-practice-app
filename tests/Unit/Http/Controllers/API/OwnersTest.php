<?php

namespace Tests\Unit\Http\Controllers\API;

use App\Owner;
use App\Animal;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        // users
        $this->adminUser = factory(User::class)->create(['role' => 'admin']);
        $this->vetUser = factory(User::class)->create(['role' => 'vet']);

        // owners 1 request, 2 saved in DB
        $this->owner_data = factory(Owner::class)->make(["first_name" => "Test Owner Data", "user_id" => 1])->toArray();

        $this->owner_data_update = factory(Owner::class)->make(["first_name" => "Test Owner Data Update", "user_id" => 1])->toArray();

        $this->owner_DB1 = factory(Owner::class)->create(["first_name" => "Test Owner DB 1", "user_id" => 1]);
        $this->owner_DB2 = factory(Owner::class)->create(["first_name" => "Test Owner DB 2", "user_id" => 1]);
    }

    // Test all routes with No Authentication
    // Expected - Not Allowed - 401 Unauthorized
    public function testAllNoAuth()
    {
        // GET /owners/
        // fake a GET request, need to include headers so we don't redirect to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('GET', '/api/owners');
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

        // GET /owners/1
        // fake a GET request, need to include headers so we don't redirect to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('GET', '/api/owners/1');
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

        // POST
        // update some information with a PUT w/ headers so we don't get redirected to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('POST', '/api/owners/', $this->owner_data);
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

        // PUT
        // update some information with a PUT w/ headers so we don't get redirected to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('PUT', '/api/owners/1', $this->owner_data_update);
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

        // DELETE
        // update some information with a PUT w/ headers so we don't get redirected to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('DELETE', '/api/owners/1');
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();
    }

    // Test showing the index of Owners with Vet User Role
    // Expected - Allowed
    public function testIndexVet()
    {
        // act as the vet user
        $this->actingAs($this->vetUser, 'api');

        // fake a GET request
        $response = $this->call('GET', '/api/owners')->getOriginalContent();

        // check we get back two Owners that are in the DB from setup
        $this->assertSame(2, $response->count());

        // check we get back the first Owner first
        $this->assertSame("Test Owner DB 1", $response->get(0)->first_name);
    }

    // Test showing the index of owners with Admin User Role
    // Expected - Allowed
    public function testIndexAdmin()
    {
        // act as the Admin user
        $this->actingAs($this->adminUser, 'api');

        // fake a GET request
        $response = $this->call('GET', '/api/owners')->getOriginalContent();

        // check we get back two Owners that are in the DB from setup
        $this->assertSame(2, $response->count());

        // check we get back the first Owner first
        $this->assertSame("Test Owner DB 1", $response->get(0)->first_name);
    }

    // Test storing an owner with Vet user role
    // Expected - Not Allowed - 403 - not authorized
    public function testStoreVet()
    {
        // acting as vet
        $this->actingAs($this->vetUser, 'api');

        // fake post request with owner info
        $response = $this->call('POST', '/api/owners', $this->owner_data);
        
        // check we get back 403 - not authorized
        $response->assertStatus(403);

        // check it's not been added to the database (still 2 owners only from setup)
        $this->assertSame(2, Owner::all()->count());
    }

    // Test storing an owner with Admin user role
    // Expected - Allowed
    public function testStoreAdmin()
    {
        // acting as Admin
        $this->actingAs($this->adminUser, 'api');

        // fake post request with animal info
        $response = $this->call('POST', '/api/owners', $this->owner_data)->getOriginalContent();
        
        // check we get back an owner with the right name from setup
        $this->assertSame("Test Owner Data",$response->first_name);

        // check it's been added to the database
        $owner = Owner::find(3);
        $this->assertSame("Test Owner Data", $owner->first_name);
    }

    // Test Showing a single Owner with Vet User Role
    // Expected - Allowed
    public function testShowVet()
    {
        // acting as vet
        $this->actingAs($this->vetUser, 'api');

        // fake a GET request
        $response = $this->call('GET', '/api/owners/1')->getOriginalContent();

        // check we get back the ower we created in setup
        $this->assertSame("Test Owner DB 1", $response->first_name);
    }

    // Test Showing a single Owner with admin User Role
    // Expected - Allowed
    public function testShowAdmin()
    {
        // acting as admin
        $this->actingAs($this->adminUser, 'api');

        // fake a GET request
        $response = $this->call('GET', '/api/owners/1')->getOriginalContent();

        // check we get back the ower we created in setup
        $this->assertSame("Test Owner DB 1", $response->first_name);
    }

    // Test Updating owner with Vet User Role
    // Expected - Not Allowed - 403 - not authorized
    public function testUpdateVet()
    {
        // acting as vet
        $this->actingAs($this->vetUser, 'api');

        // PUT
        // update some information with a PUT 
        $response = $this->call('PUT', '/api/owners/1', $this->owner_data_update);

        // check we get back 403 - not authorized
        $response->assertStatus(403);
    }

    // Test Updating owner with Admin User Role
    // Expected - Allowed
    public function testUpdateAdmin()
    {
        // acting as admin
        $this->actingAs($this->adminUser, 'api');

        // PUT
        // update some information with a PUT 
        $response = $this->call('PUT', '/api/owners/1', $this->owner_data_update)->getOriginalContent();

        // check we get back the updated info
        $this->assertSame("Test Owner Data Update", $response->first_name);

        // check DB has updated info
        $owner_DB = Owner::all()->first();
        $this->assertSame("Test Owner Data Update", $owner_DB->first_name);

        // check we've not *added* a new animal
        $owners = Owner::all();
        $this->assertSame(2, $owners->count()); // should still be only 2 owners
        $this->assertSame("Test Owner Data Update", $owner_DB->first()->first_name);
    }

    // Test deleting Owner with Vet User Role
    // Expected - Not Allowed - 403 - not authorized
    public function testDestroyVet()
    {
        // act as Vet
        $this->actingAs($this->vetUser, 'api');  
    
        // fake a DELETE request an Owner
        $response = $this->call('DELETE', '/api/owners/1');

        // check we get back 403 - not authorized
        $response->assertStatus(403);
    }

    // Test deleting Owner with Admin User Role
    // Expected - Allowed 
    public function testDestroyAdmin()
    {
        // act as admin
        $this->actingAs($this->adminUser, 'api');  
    
        // fake a DELETE request an Owner
        $response = $this->call('DELETE', '/api/owners/1');
        $response = $this->call('DELETE', '/api/owners/2');

        // check we get back 204 
        $response->assertStatus(204);

        // check they've been removed from the database
        $this->assertTrue(Owner::all()->isEmpty());
    }
}
