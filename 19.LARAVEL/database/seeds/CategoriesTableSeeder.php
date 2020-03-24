<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('categories')->insert([
				  'name'         => 'Technology',
				  'description'  => 'This category shows info about technology products tha you can see',
		]);
          
          $cat = new App\Category;
          $cat->name = 'Sport';
          $cat->description = 'This category shows info about technology products tha you can see';
          $cat->save();

          $cat = new App\Category;
          $cat->name = 'Home';
          $cat->description = 'This category shows info about technology products tha you can see';
          $cat->save();
    }
}
