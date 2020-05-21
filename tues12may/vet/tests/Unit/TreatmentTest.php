<?php

namespace Tests\Unit;

use App\Treatment;
use PHPUnit\Framework\TestCase;
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
}
