<?php

namespace App;

class FizzBuzz
{
    public function forNumber(int $num)
    {
        $result = "";
        $result .= $num % 3 === 0 ? "Fizz" : "";
        $result .= $num % 5 === 0 ? "Buzz" : "";
        $result .= $num % 7 === 0 ? "Rarr" : "";

        if (!$result) {
            return "".$num;
        }

        return $result;
    }
}