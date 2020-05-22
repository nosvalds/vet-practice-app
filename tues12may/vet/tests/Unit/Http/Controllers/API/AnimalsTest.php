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

        //See Below
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiMDZlYzE5MjJhZWM2NmIxYTgzYTRkMzRlYTdhNWQ3NTViYWZiZDA4NjZlZWI4OGI3YmVhMGEyMWI5NjkzOWNkYzY0MzQ2Yzg5OWI2NDIwMzkiLCJpYXQiOjE1OTAxMzQ1NDgsIm5iZiI6MTU5MDEzNDU0OCwiZXhwIjoxNjIxNjcwNTQ3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.g6Jwd_4J5PAe8p3adrvTGquPbRw6LMWfx0B3cTRD-JAXA2vjvOmsSqjLQZnPQDGV5oIaIdPq8s9VG-Rxe0_QcL9PraoVqyHzHE952Ft4RiSj0yJxZmVuynLehoJzffDWsT1QT1sDbvsJVJo07XhyKaVrUpvVtcmS9ra64U8r48SXKzu2t0sUrYtBD_ynOwmr3C90j-crCj_Zusvhp2qm3CjBXG2_4CQ5IQskf30hj03gzdkdPMe8JBVwe7PXqNKo9qc2Bp9qX0wvhlYjU8aJKJselB3NQz7N3_6TLesmJcI_17R7_5fFaMSGOLb60oH8Pd4UAVUEYYpGfLF_0dty-Q2VGJadYjeTFrLy9CsNj7OLtnJcoioM04XkbRSLxNPgx4CoA2vIRTEYxw2cqSb-dCXMDsURwjylRg3By96cLhyWn-sO9F7OV8VF4kt-IEIKezHUqlydphTsmFb67UCtgz4h-J1N-mjELHser6IM1AfUDJ9M7-UeDkDH3S4ARFqlosZd8XwB8RKNymUAZu4OJLdN6ax48rMbiGvTzpQRPlPvQFw1I-y3VlHKyKRqfasQNplV08RyBKrwwXPVwGzVdfnXbcxRAn9fMI_vq4sBr-c1AvA0qAuDG_EjXitzQWky68vP-l7Gq_oANWh-W0ulBwvTtrXCNl5KoaYlOQTOScI";

        $headers = [ 'Authorization' => "Bearer $token"];
        //dd($headers);
        $response = $this->call('POST', '/api/animals', $animal_data, $headers)->getOriginalContent();
        dd($response);
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

        // check we've not *added* a new animal
        $animals = Animal::all();
        $this->assertSame(1, $animal->count());
        $this->assertSame("Animal 2", $animals->first()->name);
        $this->assertSame(2, $animal->first()->treatments->count());

    }

    public function testDestroy()
    {
        // create an Animal
        factory(Animal::class)->create(["name" => "Animal 1", "owner_id" => 1]);

        // fake a DELETE request for that Animal
        $response = $this->call('DELETE', '/api/animals/1');

        // check it's been removed from the database
        $this->assertTrue(Animal::all()->isEmpty());
    }
}
