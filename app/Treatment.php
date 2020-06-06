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

    static public function fromString(string $string) : Treatment
    {
        $string = trim($string); // remove whitespace
        $treatment = Treatment::where("name", $string)->first();
        return $treatment ? $treatment : Treatment::create(["name" => $string]);
           
    }

    static public function fromStrings(array $strings) : Collection
    {
        return collect($strings)->map([Treatment::class, "fromString"]);
    }
}
