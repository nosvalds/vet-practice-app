<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;
use App\Animal;
use App\Http\Requests\OwnerRequest;
use App\Http\Requests\AnimalRequest;


class Owners extends Controller
{
    public function index(Request $request) 
    {
        $search_string = $request->query("search_string");
        if ($search_string !== null) {
            $search_string = $search_string . "%";
            $owners = Owner::where('first_name', 'like', $search_string); // first name search
            $owners = Owner::where('last_name', 'like', $search_string)->union($owners)->paginate(10); // union last name search + paginate
            dd($owners);
            return view("welcome",['page' => 'Owners','owners' => $owners]);
        }
        $owners = Owner::paginate(10);
        return view("welcome",['page' => 'Owners','owners' => $owners]);
    }

    public function show(Owner $owner, Request $request) // Route Model Binding automatically pulls Owner->find({id});
    {
        return view("welcome",['page' => 'Owner','owner' => $owner]);
    }

    public function create()
    {   
        $blankOwner = new Owner; // pass in empty owner object so our ternary operators don't break
        return view("owners/form", ['page' => 'Create Owner', 'owner' => $blankOwner]);
    }

    public function createOwner(OwnerRequest $request)
    { // save owner from form into the DB
        $data = $request->all(); 

        $owner = Owner::create($data); // save into DB

        return redirect("/owners/{$owner->id}"); // send them to the owner they just submitted
    }

    public function edit(Owner $owner)
    {
        return view("owners/form", ['page' => 'Modify Owner','owner' => $owner]);
    }

    public function addAnimal(Owner $owner, AnimalRequest $request)
    {
        $data = $request->all(); // turn request into array
        $id = $owner->id; // get owner id
        $data['owner_id'] = $id; // set owner id to associate animal with the owner
        $animal = Animal::create($data); // save to DB
        return redirect("/owners/{$id}"); // redirect to owners page
    }
}
