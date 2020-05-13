<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;

class Owners extends Controller
{
    public function index() {
        $owners = Owner::simplePaginate(5);
        return view("welcome",['page' => 'Owners','owners' => $owners]);
    }

    public function show(Owner $owner) // Route Model Binding automatically pulls Owner->find({id});
    {
        return view("welcome",['page' => 'Owner','owner' => $owner]);
    }
}
