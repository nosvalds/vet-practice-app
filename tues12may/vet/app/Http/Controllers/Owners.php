<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;
use App\Http\Requests\OwnerRequest;

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

    public function create()
    {
        return view("owners/form", ['page' => 'Create Owner']);
    }

    public function createOwner(OwnerRequest $request)
    { // save owner from form into the DB
        $data = $request->all(); 

        $owner = Owner::create($data); // save into DB

        return redirect("/owners/{$owner->id}"); // send them to the owner they just submitted
    }
}
