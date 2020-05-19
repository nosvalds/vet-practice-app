<?php

namespace App\Http\Controllers\API\Owners;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Owner;
use App\Animal;
use App\Http\Requests\API\AnimalRequest as Request;
use App\Http\Resources\API\AnimalResource;

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
        $animal_data = $request->all(); // turn request into array 
        $new_animal = $owner->animals()->create($animal_data);
        return new AnimalResource($new_animal);
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
        $animals = $owner->animals;

        return AnimalResource::collection($animals);
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
