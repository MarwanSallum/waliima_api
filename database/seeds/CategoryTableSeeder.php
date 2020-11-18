<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i < 10; $i++){
            Category::create([
                'user_id' => 1,
                'name' =>  'category -'.$i,
                'image' => 'category -'.$i.'image',
            ]);
        }

    }
}
