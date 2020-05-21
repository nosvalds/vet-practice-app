<?php

namespace App;

class Cracker
{    
    private $keys = [];

    public function __construct(string $key)
    {
        $keyAry = explode(" ",$key);
        $alphabetAry = range('a','z');
   
        $this->keys = array_combine($keyAry, $alphabetAry);
   
    }

    public function decryptLetter(string $code) : string   
    {
        if ($code === " ") {
            return $code;
        }
        return $this->keys[$code];

    }

    public function decrypt(string $code)
    {   
        $result = '';
        $codeAry = mb_str_split($code);
        foreach ($codeAry as $char) {
            $result .= $this->decryptLetter($char);
        }
        return $result;
     
    }

}