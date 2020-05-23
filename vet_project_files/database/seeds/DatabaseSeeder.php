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
        // DB::table('users')->insert(factory(App\User::class)->make(
        //     ["name" => "Nik Osvalds",
        //      "email" => "nosvalds@gmail.com",
        //      "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi", // password
        //      "role" => "admin",
        //     ]
        // )->toArray()); // create admin user
        DB::table('users')->insert(factory(App\User::class,8)->make()->toArray());
        DB::table('owners')->insert(factory(App\Owner::class,100)->make()->toArray());
        DB::table('animals')->insert(factory(App\Animal::class,250)->make()->toArray());
    }
}
