<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Owner;
use App\Http\Requests\API\OwnerRequest as Request;
use App\Http\Requests\OwnerDestroyRequest;
use App\Http\Requests\OwnerStoreRequest;
use App\Http\Resources\API\OwnerResource;

class Owners extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return all Owners from the database
        return OwnerResource::collection(Owner::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OwnerStoreRequest $request)
    {
        // get request data
        $data = $request->all();

        // create new record in DB
        $owner = Owner::create($data);

        return new OwnerResource($owner);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        //return the requested owner
        return new OwnerResource($owner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OwnerStoreRequest $request, Owner $owner)
    {
        // get all the request data
        $data = $request->all();

        // update owner in the database
        $owner->update($data);

        // return updated version
        return new OwnerResource($owner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OwnerDestroyRequest $request,Owner $owner)
    {
        // delete owner from the DB
        $owner->delete();

        // return 204
        return response(null, 204);
    }
}
