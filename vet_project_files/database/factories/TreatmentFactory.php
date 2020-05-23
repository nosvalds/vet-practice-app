<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Treatment;
use Faker\Generator as Faker;

$factory->define(Treatment::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement($array = array('Neuter', 'Toenail Removal','spay', 'Flea Treatment', 'de-clawing', 'shaving', 'petting therapy'))
    ];
});
