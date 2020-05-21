<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Animal;
use App\Http\Requests\API\AnimalRequest as Request;
use App\Http\Resources\API\AnimalResource;
use App\Treatment;

class Animals extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return all Animals from the database
        return AnimalResource::collection(Animal::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get request data for the animal
        $animal_data = $request->only("name", "date_of_birth", "type", "weight", "height", "biteyness", "owner_id");
        $animal = Animal::create($animal_data)->setTreatments($request->get("treatments"));

        // return resource
        return new AnimalResource($animal);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        // return the requested animal info
        return new AnimalResource($animal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animal $animal)
    {
        //dd($request, $animal);
        // get request data for the animal
        $animal_data = $request->only("name", "date_of_birth", "type", "weight", "height", "biteyness", "owner_id");

        // save data
        $animal->fill($animal_data)->save();
        
        // update treatments
        $animal->setTreatments($request->get("treatments"));

        // return updated version
        return new AnimalResource($animal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        // delete animal from the DB
        $animal->delete();

        // return 204
        return response(null, 204);
    }
}
