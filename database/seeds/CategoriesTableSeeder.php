<?php

use Illuminate\Database\Seeder;
use App\Restaurant;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	$resturants= Restaurant::all();

        	foreach ($resturants as $resturant) {

				for($i=0;$i<5;$i++){
					 factory(Category::class,5)->create([
			    	 	'resturant_id'=>$resturant->id
				     ]);
				}        
			}
	    

    }
}
