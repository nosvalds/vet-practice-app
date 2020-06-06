<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Had to remove password from -> protected $hidden = [ ]; array in App\User.php to allow saving passwords from the factory
        factory(App\User::class)->create(
            ["name" => "Nik Osvalds",
             "email" => "nosvalds@gmail.com",
            // Password here
             "role" => "admin",
            ]
        ); // create admin user

        // create vet users
        factory(App\User::class,2)->create();
        
        // create owners
        factory(App\Owner::class,50)->create();

        // create animals with treatments
        factory(App\Animal::class, 100)->create()->each(function ($animal) {
            $animal->treatments()->save(factory(App\Treatment::class)->make());
            $animal->treatments()->save(factory(App\Treatment::class)->make());
            $animal->treatments()->save(factory(App\Treatment::class)->make());
        });
        
    }
}
