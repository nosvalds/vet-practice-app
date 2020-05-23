<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "max:100"],
            "type" => ["required", "string","max:100"],
            "date_of_birth" => ["required", "date"],
            "biteyness" => ["required", "int"],
            "weight" => ["required"],
            "height" => ["required"],
            "treatments" => ["array"], // don't require treatments on animal creation
            "treatments.*" => ["string", "max:100"], // things inside of the array
            //"owner_id" => ["required"] 
        ];
    }
}
