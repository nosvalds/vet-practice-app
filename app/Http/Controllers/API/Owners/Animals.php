<?php

namespace App\Http\Controllers\API\Owners;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Owner;
use App\Animal;
use App\Http\Requests\AnimalStoreRequest;
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
    public function store(Owner $owner, AnimalStoreRequest $request)
    {
        // turn request into array, get only animal data fields
        $animal_data = $request->only("name", "date_of_birth", "type", "weight", "height", "biteyness", "owner_id"); 

        // create the new animal associated with the owner
        // get treatments from the request and store them in the DB as well associated with the animal.
        $new_animal = $owner->animals()->create($animal_data);

        // if treatment data is present then associate with animal, if not, don't try
        $treatment_data = $request->get("treatments");
        if ($treatment_data !== null) {
            $new_animal->setTreatments($treatment_data);
        }
        
        // return resource
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
