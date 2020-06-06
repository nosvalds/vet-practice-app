<?php

namespace App;

class RomanNumeral
{
    private $dictionary = [
        1000 => 'M',
        900 => 'CM',
        500 => 'D',
        400 => 'CD',
        100 => 'C',
        90 => 'XC',
        50 => 'L',
        40 => 'XL',
        10 => 'X',
        9 => 'IX',
        5 => 'V',
        4 => 'IV',
        1 => 'I',
    ];

    public function forNumber(int $num)
    {
        $result = '';
        foreach ($this->dictionary as $value => $numeral) {
            while ($num >= $value) {
                $result .= $numeral;
                $num -= $value;
            }
        }
        return $result;
    }
}