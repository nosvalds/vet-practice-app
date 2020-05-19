<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Animal;

class AnimalTest extends TestCase
{
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
}
