<?php

namespace Database\Seeders;

use AliQasemzadeh\JetAdmin\Models\Category;
use AliQasemzadeh\JetAdmin\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->title = 'Main Support';
        $category->type = 'ticket';
        $category->language = 'en';
        $category->save();

        $category = new Category();
        $category->title = 'News';
        $category->type = 'article';
        $category->language = 'en';
        $category->save();
    }
}
