<?php

namespace Tests\Unit;

use App\Treatment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class TreatmentTest extends TestCase
{
    use RefreshDatabase;
    
    public function testFromString()
    {
        // call method to turn 1 string into a Treatment object
        $result = Treatment::fromString("Test");
        
        // see if we get back a Treatment
        $this->assertInstanceOf(Treatment::class, $result);

        // check the tag has the right name
        $this->assertSame("Test", $result->name);
    }

    public function testFromString2()
    {
        // call method to turn 1 string into a Treatment object
        $result = Treatment::fromString("Neuter");

        // see if we get back a Treatment
        $this->assertInstanceOf(Treatment::class, $result);

        // check the tag has the right name
        $this->assertSame("Neuter", $result->name);
    }

    public function testFromStringToDB()
    {
        // call method to turn 1 string into a Treatment object
        $result = Treatment::fromString("Neuter");

        // see if we get back a Treatment
        $this->assertInstanceOf(Treatment::class, $result);

        // check the tag has the right name
        $this->assertSame("Neuter", $result->name);

        // get from DB
        $DB_result = Treatment::all()->first();
        
        // check it's a treatment
        $this->assertInstanceOf(Treatment::class, $DB_result);

        // check the tag has the right name from the DB
        $this->assertSame("Neuter", $DB_result->name);
    }

    public function testFromStringNoDupDB()
    {
        // call method to turn 1 string into a Treatment object
        $result = Treatment::fromString("Test");
        $result = Treatment::fromString("Test");
        $allTreatments = Treatment::where("name", "Test");

        $this->assertSame(1, $allTreatments->count());
    }

    public function testFromStrings()
    {
        $result = Treatment::fromStrings(["Test", "Neuter"]);

        // check it's a Collection
        $this->assertInstanceOf(Collection::class, $result);

        // check the first item is "Test"
        $this->assertSame("Test", $result[0]->name);

        // check the second item is "Hammock"
        $this->assertSame("Neuter", $result[1]->name);

    }

    public function testFromStringTrim()
    {
        // call method to turn 1 string into a Treatment object
        $result = Treatment::fromString(" Test Treatment");
        
        // see if we get back a Treatment
        $this->assertInstanceOf(Treatment::class, $result);

        // check the treatment has removed whitespace
        $this->assertSame("Test Treatment", $result->name);
    }
}
