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

}
