<?php

use Illuminate\Database\Seeder;
use App\Restaurant;
class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Restaurant::class,3)->create();
    }
}
