<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animal;
use App\Owner;
//use App\Http\Requests\AnimalRequest;

class Animals extends Controller
{
    public function index() 
    {
        $animals = Animal::paginate(10);
        return view("animals",['page' => 'Animals','animals' => $animals]);
    }

    public function show(Animal $animal) // Route Model Binding automatically pulls Owner->find({id});
    {
        $owner = $animal->owner;
        return view("animals",['page' => 'Animal','animal' => $animal, 'owner' => $owner]);
    }
}
