<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\RomanNumeral;

class RomanNumeralTest extends TestCase
{
    // store the RomanNumeral object
    private $rn;
    // create a new instance of the object
    // when the test starts
    public function setUp() : void
    {
    parent::setUp();
    $this->rn = new RomanNumeral();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test1()
    {
        $this->assertSame("I", $this->rn->forNumber(1));
    }
    
    public function test2()
    {
        $this->assertSame("II", $this->rn->forNumber(2));
    }
    
    public function test3()
    {
        $this->assertSame("III", $this->rn->forNumber(3));
    }
    
    public function test4()
    {
        $this->assertSame("IV", $this->rn->forNumber(4));
    }
    
    public function test5()
    {
        $this->assertSame("V", $this->rn->forNumber(5));
    }
    
    public function test6()
    {
        $this->assertSame("VI", $this->rn->forNumber(6));
    }
    
    public function test7()
    {
        $this->assertSame("VII", $this->rn->forNumber(7));
    }
    
    public function test8()
    {
        $this->assertSame("VIII", $this->rn->forNumber(8));
    }
    
    public function test9()
    {
        $this->assertSame("IX", $this->rn->forNumber(9));
    }
    
    public function test10()
    {
        $this->assertSame("X", $this->rn->forNumber(10));
    }
    
    public function test11()
    {
        $this->assertSame("XI", $this->rn->forNumber(11));
    }
    
    public function test12()
    {
        $this->assertSame("XII", $this->rn->forNumber(12));
    }
    
    public function test13()
    {
        $this->assertSame("XIII", $this->rn->forNumber(13));
    }
    
    public function test14()
    {
        $this->assertSame("XIV", $this->rn->forNumber(14));
    }
        
    public function test15()
    {
        $this->assertSame("XV", $this->rn->forNumber(15));
    }
        
    public function test16()
    {
        $this->assertSame("XVI", $this->rn->forNumber(16));
    }
        
    public function test17()
    {
        $this->assertSame("XVII", $this->rn->forNumber(17));
    }
        
    public function test18()
    {
        $this->assertSame("XVIII", $this->rn->forNumber(18));
    }
        
    public function test19()
    {
        $this->assertSame("XIX", $this->rn->forNumber(19));
    }
        
    public function test40()
    {
        $this->assertSame("XL", $this->rn->forNumber(40));
    }
        
    public function test50()
    {
        $this->assertSame("L", $this->rn->forNumber(50));
    }
        
    public function test90()
    {
        $this->assertSame("XC", $this->rn->forNumber(90));
    }
        
    public function test100()
    {
        $this->assertSame("C", $this->rn->forNumber(100));
    }
        
    public function test400()
    {
        $this->assertSame("CD", $this->rn->forNumber(400));
    }
        
    public function test500()
    {
        $this->assertSame("D", $this->rn->forNumber(500));
    }
        
    public function test900()
    {
        $this->assertSame("CM", $this->rn->forNumber(900));
    }
        
    public function test1000()
    {
        $this->assertSame("M", $this->rn->forNumber(1000));
    }
        
    public function test3994()
    {
        $this->assertSame("MMMCMXCIV", $this->rn->forNumber(3994));
    }
}
