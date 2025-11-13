<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
            'name' => 'Fiksi'
        ]);
        Category::create([
            'name' => 'Non Fiksi'
        ]);
        Category::create([
            'name' => 'Ilmiah'
        ]);
        Category::create([
            'name' => 'Biografi'
        ]);
        Category::create([
            'name' => 'Sejarah'
        ]);
        Category::create([
            'name' => 'Teknologi'
        ]);
        Category::create([
            'name' => 'Seni'
        ]);
        Category::create([
            'name' => 'Agama'
        ]);
        Category::create([
            'name' => 'Budaya'
        ]);
    }
}
