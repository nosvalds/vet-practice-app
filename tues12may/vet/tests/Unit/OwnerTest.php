<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnerTest extends TestCase
{   
    use RefreshDatabase;
    public function setUp() : void      
    {
        parent::setUp();

       $this->user = factory(\App\User::class)->create();
        $this->owner = new Owner ([
            "first_name" => "Nik",
            "last_name" => "Osvalds",
            "telephone" => "+44123456789",
            "address_1" => "123 Road St",
            "address_2" => "Apt 1",
            "town" => "Bristol",
            "postcode" => "BS3 5HG",
            "user_id" => $this->user->id,
            "bad_property" => "bad value"
        ]);
    }
    
    public function testFillable()
    {
        // Positive tests - data is set appropriately
        $this->assertSame("Nik", $this->owner->first_name);
        $this->assertSame("Osvalds", $this->owner->last_name);
        $this->assertSame("+44123456789", $this->owner->telephone);
        $this->assertSame("123 Road St", $this->owner->address_1);
        $this->assertSame("Apt 1", $this->owner->address_2);
        $this->assertSame("Bristol", $this->owner->town);
        $this->assertSame("BS3 5HG", $this->owner->postcode);
        $this->assertSame(1, $this->owner->user_id);

        // test that setting "bad_property" doesn't work
        $this->assertSame(null, $this->owner->bad_property);
    }

    public function testValidPhoneNumber()
    {
        // default "telephone" => "+44123456789" is valid
        $this->assertTrue($this->owner->validPhoneNumber());

        $this->owner->telephone = "+12345142"; // Invalid < 10
        $this->assertFalse($this->owner->validPhoneNumber());
        
        $this->owner->telephone = "+123456789123456"; // Invalid > 14
        $this->assertFalse($this->owner->validPhoneNumber());

        $this->owner->telephone = "+A2345678912"; // Invalid contains A letter
        $this->assertFalse($this->owner->validPhoneNumber());

        $this->owner->telephone = "12345678912"; // Invalid missing +
        $this->assertFalse($this->owner->validPhoneNumber());
    }

    public function testDatabaseCreate()
    {
        $owner_DB = Owner::create(
            [
                "first_name" => "Nik",
                "last_name" => "Osvalds",
                "telephone" => "+44123456789",
                "address_1" => "123 Road St",
                "address_2" => "Apt 1",
                "town" => "Bristol",
                "postcode" => "BS3 5HG",
                "user_id" => $this->user->id,
            ]
            );

        $ownerFromDB = Owner::all()->first();

        $this->assertSame($owner_DB->first_name, $ownerFromDB->first_name);
    }

    public function testNumOfPets()
    {
        
        $owner = factory(\App\Owner::class)->create();
        $this->assertSame(0, $owner->numberOfPets());
        
        // Add 1 Pet
        $animal_data = factory(\App\Animal::class)->make()->toArray();
        $animal = $owner->animals()->create($animal_data); // potentially save is the wrong method, https://laravel.com/docs/7.x/database-testing#writing-factories

        $animal_data = factory(\App\Animal::class)->make()->toArray();
        $owner->animals()->create($animal_data);
        dd($owner);
        
        $this->assertSame(1, $owner->numberOfPets());
    }
}
