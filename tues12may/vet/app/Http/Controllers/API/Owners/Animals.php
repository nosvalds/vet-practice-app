<?php

namespace App\Http\Controllers\API\Owners;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Owner;
use App\Animal;
use App\Http\Requests\API\AnimalRequest as Request;

class Animals extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Owner $owner, Request $request)
    {
        $data = $request->all(); // turn request into array
        $id = $owner->id; // get owner id
        $data['owner_id'] = $id; // set owner id to associate animal with the owner
        $animal = Animal::create($data); // save to DB
        return $animal;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        //
        return $owner->animals;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
