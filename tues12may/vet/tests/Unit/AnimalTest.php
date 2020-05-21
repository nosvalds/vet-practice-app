<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Animal;
use App\User;
use App\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnimalTest extends TestCase
{
    use RefreshDatabase;
    public function testDangerous()
    {
        $animal = new Animal ([
            "biteyness" => 1, // Dangerous = false
        ]);
        $this->assertFalse($animal->dangerous()); 

        $animal->biteyness = 2; // Dangerous = false
        $this->assertFalse($animal->dangerous()); 
        
        $animal->biteyness = 3; //  Dangerous = true
        $this->assertTrue($animal->dangerous()); 
        
        $animal->biteyness = 4; //  Dangerous = true
        $this->assertTrue($animal->dangerous()); 
        
        $animal->biteyness = 5; //  Dangerous = true
        $this->assertTrue($animal->dangerous()); 
    }

    public function testAddTreatment()
    {
        // user
        $user = factory(User::class)->create();
        $owner = factory(Owner::class)->create(["user_id" => 1]);

        // create animal
        factory(Animal::class)->create(["owner_id" => 1]);

        // get from DB
        $animal = Animal::all()->first();

        // set treatments
        $animal->setTreatments(["Fel-O-Vax Lv-K", "Pecti-Cap", "Zymox Ear Cleanser"]);

        // get from DB again
        $fromDB = Animal::all()->first();
        // check if we have 3 treatments now
        $this->assertSame(3, $fromDB->treatments->count());

        // // set treatments
        // $animal->setTreatments(["Fel-O-Vax Lv-K"]);

        // // check treatments have been removed
        // $fromDB = Animal::all()->first();
        // $this->assertSame(1, $fromDB->treatments->count());
    }
}
