<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Owner;
use App\User;
use App\Animal;
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

        // $this->owner->telephone = "+12345142"; // Invalid < 10
        // $this->assertFalse($this->owner->validPhoneNumber());
        
        // $this->owner->telephone = "+123456789123456"; // Invalid > 14
        // $this->assertFalse($this->owner->validPhoneNumber());

        // $this->owner->telephone = "+A2345678912"; // Invalid contains A letter
        // $this->assertFalse($this->owner->validPhoneNumber());

        // $this->owner->telephone = "12345678912"; // Invalid missing +
        // $this->assertFalse($this->owner->validPhoneNumber());

        // refactoring
        $invalidNumbers = ["+12345142", "+123456789123456", "+A2345678912","12345678912"];

        foreach ($invalidNumbers as $number){
            $this->owner->telephone = $number;
            $this->assertFalse($this->owner->validPhoneNumber());
        }
    }

    public function testDatabaseCreate()
    {
        // create owner w/ Owner Factory
        factory(Owner::class)->create(["first_name" => "John", "last_name" => "Doe"]); // Owner::create([])
    
        // fetch from DB
        $ownerFromDB = Owner::all()->first();

        // compare values
        $this->assertSame("John", $ownerFromDB->first_name); // make sure we compare against a known value
        $this->assertSame("Doe", $ownerFromDB->last_name);
    }

    public function testNumOfPets()
    {
        // create owner w/ Owner factory
        $owner = factory(Owner::class)->create();
      
        for ($i = 0; $i < 5; $i += 1) { 
            // get owner from DB
            $owner = Owner::find(1);

            // Make Assertion 
            $this->assertSame($i, $owner->numberOfPets());

            // Add 1 Pet
            $animal_data = factory(Animal::class)->make()->toArray(); // create animal object with factory
            $owner->animals()->create($animal_data); // save animal to DB associated with our owner
        }
    }

    public function testOwnerFormFilledCorrect()
    {
        // create user with admin role so auth allows POST to database
        $user = factory(User::class)->create(['role' => 'admin']);

        // create an owner object using the factory, set name Joe
        $owner_data = factory(Owner::class)->make(["first_name" => "Joe"])->toArray();

        // use acting as to POST the data as the user
        $this->actingAs($user)->call('POST', '/owners/create', $owner_data);

        // grab that owner from DB
        $ownerFromDB = Owner::all()->first();

        // check if it's Joe
        $this->assertSame('Joe', $ownerFromDB->first_name);
    }
}
