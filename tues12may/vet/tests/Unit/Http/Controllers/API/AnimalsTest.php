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

    public function testIndex()
    {

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

    public function testStore()
    {
        $animal_data = factory(Animal::class)->make([
            "name" => "Animal 1",
            "owner_id" => 1,
            "treatments" => ["Neutering", "Spaying"],
            ])->toArray();

        $response = $this->call('POST', '/api/animals', $animal_data)->getOriginalContent();
        
        // check we get back an animal with 2 treatments
        $this->assertSame("Animal 1",$response->name);
        $this->assertSame(2,$response->treatments->count());

        // check it's been added to the database
        $animal = Animal::all()->first();
        $this->assertSame("Animal 1", $animal->name);
    }

    public function testShow()
    {
        // create animal in DB
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a GET request
        $response = $this->call('GET', '/api/animals/1')->getOriginalContent();

        // check we get back the Animal we created 
        $this->assertSame("Animal 1", $response->name);
    }

    public function testUpdate()
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
        $response = $this->call('PUT', '/api/animals/1', $animal_data)->getOriginalContent();

        // check we get back the updated info
        $this->assertSame("Animal 2", $response->name);

        // check DB has updated info
        $animal = Animal::all()->first();
        $this->assertSame("Animal 2", $animal->name);

        // check we've not *added* a new article
        $animals = Animal::all();
        $this->assertSame(1, $animal->count());
        $this->assertSame("Animal 2", $animals->first()->name);
        $this->assertSame(2, $animal->first()->treatments->count());

    }
}
