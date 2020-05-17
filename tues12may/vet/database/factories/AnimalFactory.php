<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Animal;
use Faker\Generator as Faker;
use Carbon\Carbon;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Animal::class, function (Faker $faker) {
    // $dt = Carbon::now();
    // $dt->settings([
    //     'toStringFormat' => 'Y-m-d H:i:s'
    // ]);
    //dd($dt->toDateTimeString());
    return [
        'name' => $faker->name,
        'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'type' => $faker->randomElement($array = array ('Dog','Cat','Tiger','Sugar Glider','Donkey','Fish','Wombat','Lion')),
        'weight' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 200),
        'height' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
        'biteyness' => $faker->numberBetween($min = 1, $max = 5),
        'owner_id' => $faker->numberBetween($min = 1, $max = 99),
        //'created_at' =>  $faker->iso8601($max = 'now')
        //'updated_at' => $dt->toDateTimeString()
    ];
});
