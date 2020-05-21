<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Treatment extends Model
{
    protected $fillable = [
        'name'
    ];
    // don't need timestamps
    public $timestamps = false;

    public function animals()
    {
        return $this->belongsToMany(Animal::class);
    }

    public static function fromStrings(array $treatments)
    {
        //         It should take an array of strings and return a Collection of Treatment objects

        // $treatments = Treatment::fromStrings(["Fel-O-Vax Lv-K", "Pecti-Cap", "Zymox Ear Cleanser"]);
        // Hint: even more treatments here

        // Make sure strings are trimmed before being added to the database

        // If a Treatment already exists, make sure it doesn't get added twice
        //     
    }
}
