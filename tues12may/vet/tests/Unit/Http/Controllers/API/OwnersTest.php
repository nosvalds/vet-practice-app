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

        // owners 1 request, 1 saved in DB
        $this->owner_data = factory(Owner::class)->make(["first_name" => "Test Owner Data", "user_id" => 1])->toArray();

        $this->owner_data_update = factory(Owner::class)->make(["first_name" => "Test Owner Data Update", "user_id" => 1])->toArray();

        $this->owner_DB1 = factory(Owner::class)->create(["first_name" => "Test Owner DB 1", "user_id" => 1]);
        $this->owner_DB2 = factory(Owner::class)->create(["first_name" => "Test Owner DB 2", "user_id" => 1]);
    }

    // Test showing the index of Animals with No Authentication
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
        $response = $this->withHeaders(["Accept" => "application/json"])->json('POST', '/api/animals/', $this->owner_data);
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

        // PUT
        // update some information with a PUT w/ headers so we don't get redirected to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('PUT', '/api/animals/1', $this->owner_data_update);
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();

        // DELETE
        // update some information with a PUT w/ headers so we don't get redirected to login page
        $response = $this->withHeaders(["Accept" => "application/json"])->json('DELETE', '/api/animals/1');
        
        // check we get back no 401 response/not authorized
        $response->assertUnauthorized();
    }

    // Test showing the index of Animals with Vet User Role
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

    // Test showing the index of Animals with Admin User Role
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

}
