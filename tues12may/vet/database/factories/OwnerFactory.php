<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Owner;
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

$factory->define(Owner::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'telephone' => $faker->e164PhoneNumber,
        'town' => $faker->city,
        'postcode' => $faker->postcode,
        'address_1' => $faker->streetName,
        'address_2' => $faker->secondaryAddress,
        //'created_at' => Carbon::now(),
        //'updated_at' => Carbon::now()
        // SQLSTATE[22007]: Invalid datetime format: 1292 Incorrect datetime value: '2020-05-12T19:45:50.000000Z' for column 'created_at' at row 1 (SQL: insert into `owners` (`first_name`, `last_name`, `telephone`, `town`, `postcode`, `address_1`, `address_2`, `created_at`, `updated_at`) values (Alford, Effertz, +7892344425469, South Harmonyside, 53275, Little Parkways, Suite 729, 2020-05-12T19:45:50.000000Z, 2020-05-12T19:45:50.000000Z))
    ];
});
