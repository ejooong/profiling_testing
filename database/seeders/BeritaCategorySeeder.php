<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita\BeritaCategory;

class BeritaCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kegiatan Partai', 'color' => '#e31b23', 'order' => 1],
            ['name' => 'Bakti Sosial', 'color' => '#10b981', 'order' => 2],
            ['name' => 'Rapat Koordinasi', 'color' => '#3b82f6', 'order' => 3],
            ['name' => 'Pelantikan', 'color' => '#8b5cf6', 'order' => 4],
            ['name' => 'Politik', 'color' => '#001F3F', 'order' => 5],
            ['name' => 'Olahraga', 'color' => '#f59e0b', 'order' => 6],
            ['name' => 'Webinar', 'color' => '#6366f1', 'order' => 7],
        ];

        foreach ($categories as $category) {
            BeritaCategory::create([
                'name' => $category['name'],
                'slug' => \Illuminate\Support\Str::slug($category['name']),
                'color' => $category['color'],
                'order' => $category['order'],
                'is_active' => true,
            ]);
        }
    }
}