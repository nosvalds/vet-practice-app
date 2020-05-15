<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = ["name", "date_of_birth", "type", "weight", "height", "biteyness", "owner_id"]; // designates which fields should be filled in the DB.
    // setting up link between animals and owners
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    // dangerous method
    public function dangerous() : bool
    {
       return $this->biteyness >= 3;
    }

    // age
    public function age()
    {
        $result = new Carbon($this->date_of_birth);
        if ($result !== null) {
            return $result->diffForHumans();
        }
        return "Unknown birthday";
    }
}
