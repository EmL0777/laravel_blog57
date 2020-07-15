<?php

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();  // 先清空 table
        factory(Post::class, 20)->create();  // 一次寫入 20 篇文章
    }
}
