<?php

use Illuminate\Database\Seeder;
use App\Menu;
use App\Category;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories= Category::all();

    	foreach ($categories as $category) {

				for($i=0;$i<5;$i++){
					 factory(Menu::class,5)->create([
			    	 	'category_id'=>$category->id
				     ]);
				}        
			}

    
    }
}
