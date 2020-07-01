<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Owner extends Model
{
    protected $fillable = ["first_name", "last_name", "telephone", "address_1", "address_2", "town", "postcode", "user_id"]; // designates which fields should be filled in the DB.
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

    // return time they have been a customer for
    public function customerSince()
    {
        $result = $this->created_at;
        if ($result !== null) {
            return $result->diffForHumans();
        }
        return "Unknown for this customer";
    }

    // setting up link between animals and owners
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    // Username that created Owner
    public function createdBy()
    {
        $user = Auth::User(); // FIX ME
        return $user->name;
    }

    public function validPhoneNumber() : bool
    {
        $phone = $this->telephone;
        
        // Check + and the length of number is between 10-14 characters
        return preg_match('/^\+\d{10,14}$/', $phone);
    }

    public function numberOfPets()
    {
        return $this->animals->count();
    }
}
