<?php

use Illuminate\Database\Seeder;

class AnimalzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('animals')->insert(factory(App\Animal::class,2)->make()->toArray());
    }
}
