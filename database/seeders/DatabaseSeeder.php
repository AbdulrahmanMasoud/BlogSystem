<?php

namespace Database\Seeders;

use App\Models\Category;

use App\Models\Post;
use App\Models\Tag;

use App\Models\Admin;
use App\Models\User;


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
    \App\Models\User::factory(1)->create();
    Category::factory(5)->create();
    Post::factory(50)->create();
    Tag::factory(5)->create();
    
    $this->call(PostsTagsSeeder::class);
  }


    /**
     * Seed the application's database.
     *
     * @return void
     */
//     public function run()
//     {
//         // User::factory(20)->create();
//         // Admin::factory(5)->create();
//     }


}
