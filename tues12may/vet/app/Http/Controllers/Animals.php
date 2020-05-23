<?php

namespace App\Http\Controllers;

use App\Animal;

class Animals extends Controller
{
    public function index() 
    {
        $animals = Animal::paginate(10);
        return view("animals",['page' => 'Animals','animals' => $animals]);
    }

    public function show(Animal $animal) // Route Model Binding automatically pulls Animal->find({id});
    {
        $owner = $animal->owner; // get the animal's owner so we can send that to the view for display
        return view("animals",['page' => 'Animal','animal' => $animal, 'owner' => $owner]);
    }
}
