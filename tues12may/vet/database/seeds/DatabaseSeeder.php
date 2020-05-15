<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('animals')->insert(factory(App\Animal::class,250)->make()->toArray());
       //DB::table('owners')->insert(factory(App\Owner::class,100)->make()->toArray());
    }
}
