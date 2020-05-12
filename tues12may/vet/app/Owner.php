<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    // full name
    public function fullName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    // address
    public function fullAddress()
    {
        return "{$this->address_1}, {$this->address_2}, {$this->town}, {$this->postcode}";
    }

    // phone number
    public function formattedPhoneNumber()
    {
        $number = $this->telephone;
        return substr($number, 0, 4) . " " .
               substr($number, 4, 3) . " " .
               substr($number, 7, 4);
    }
}
