<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Rumah Tinggal', 'description' => 'Proyek pembangunan rumah tinggal'],
            ['name' => 'Renovasi', 'description' => 'Proyek renovasi dan perbaikan bangunan'],
            ['name' => 'Komersial', 'description' => 'Proyek gedung komersial dan perkantoran'],
            ['name' => 'Interior', 'description' => 'Proyek desain interior'],
        ];

        foreach ($categories as $category) {
            ProjectCategory::create($category);
        }

        // Create sample projects
        $projects = [
            [
                'title' => 'Rumah Modern Minimalis',
                'description' =>
                    'Pembangunan rumah 2 lantai dengan desain modern minimalis. Menggunakan material berkualitas tinggi dengan finishing premium. Dilengkapi dengan taman dan carport untuk 2 mobil.',
                'client_name' => 'Bapak Ahmad',
                'location' => 'Jakarta Selatan',
                'category_id' => 1,
                'year_completed' => 2024,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Renovasi Total Rumah Heritage',
                'description' =>
                    'Renovasi total rumah tua dengan tetap mempertahankan karakter heritage namun dengan sentuhan modern. Termasuk upgrade struktur dan instalasi listrik.',
                'client_name' => 'Ibu Siti',
                'location' => 'Bandung',
                'category_id' => 2,
                'year_completed' => 2024,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Kantor Startup Tech',
                'description' =>
                    'Pembangunan kantor startup teknologi dengan konsep open space modern. Dilengkapi dengan ruang meeting, pantry, dan area lounge.',
                'client_name' => 'PT. Digital Indonesia',
                'location' => 'Jakarta Barat',
                'category_id' => 3,
                'year_completed' => 2023,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Interior Apartemen Mewah',
                'description' =>
                    'Desain interior apartemen 3 bedroom dengan gaya kontemporer. Menggunakan furniture custom dan pencahayaan ambient.',
                'client_name' => 'Bapak Rudi',
                'location' => 'Surabaya',
                'category_id' => 4,
                'year_completed' => 2024,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Rumah Villa Tropis',
                'description' =>
                    'Pembangunan villa dengan konsep tropis modern. Dilengkapi dengan kolam renang dan gazebo.',
                'client_name' => 'Bapak Joko',
                'location' => 'Bali',
                'category_id' => 1,
                'year_completed' => 2023,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'title' => 'Renovasi Dapur & Kamar Mandi',
                'description' => 'Renovasi area dapur dan 2 kamar mandi dengan konsep modern minimalis.',
                'client_name' => 'Ibu Dewi',
                'location' => 'Tangerang',
                'category_id' => 2,
                'year_completed' => 2024,
                'is_featured' => false,
                'status' => 'published',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
