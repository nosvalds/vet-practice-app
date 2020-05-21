<?php

namespace Tests\Unit;

use App\Treatment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}
