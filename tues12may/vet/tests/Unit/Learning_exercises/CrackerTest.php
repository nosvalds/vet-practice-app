<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Cracker;

class CrackerTest extends TestCase
{
    public function testObjectCreation()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertIsObject($cracker);
    }

    public function testh()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame("h", $cracker->decryptLetter("&"));
    }

    public function testh2()
    {
        $cracker = new Cracker(") # ( £ * % & > < @ a b c d e f g h i j k l m n o p");
        $this->assertSame("g", $cracker->decryptLetter("&"));
    }

    public function teste()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame("e", $cracker->decryptLetter("£"));
    }

    public function testa()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame("l", $cracker->decryptLetter("a"));
    }

    public function testd()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame("o", $cracker->decryptLetter("d"));
    }

    public function testspace()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame(" ", $cracker->decryptLetter(" "));
    }

    public function testb()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame("m", $cracker->decryptLetter("b"));
    }

    public function testj()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame("u", $cracker->decryptLetter("j"));
    }
    public function test2char()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame("he", $cracker->decrypt("&£"));
    }

    public function testFull()
    {
        $cracker = new Cracker("! ) # ( £ * % & > < @ a b c d e f g h i j k l m n o");
        $this->assertSame("hello mum", $cracker->decrypt("&£aad bjb"));
    }
}
