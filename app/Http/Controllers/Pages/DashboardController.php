<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller as ParentController;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DashboardController extends ParentController
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => $this->getStats(),
            'recentProjects' => $this->getRecentProjects(),
            'projectsByCategory' => $this->getProjectsByCategory(),
        ]);
    }

    public function getStats()
    {
        return Cache::remember('dashboard_stats', 60, function () {
            $totalProjects = Project::count();
            $publishedProjects = Project::where('status', 'published')->count();
            $featuredProjects = Project::where('is_featured', true)->count();
            $totalCategories = ProjectCategory::count();

            return [
                [
                    'title' => 'Total Proyek',
                    'value' => number_format($totalProjects),
                    'description' => 'Semua proyek',
                    'icon' => 'folder',
                    'color' => 'blue',
                ],
                [
                    'title' => 'Proyek Dipublikasi',
                    'value' => number_format($publishedProjects),
                    'description' => 'Tampil di website',
                    'icon' => 'globe',
                    'color' => 'green',
                ],
                [
                    'title' => 'Proyek Unggulan',
                    'value' => number_format($featuredProjects),
                    'description' => 'Ditampilkan di beranda',
                    'icon' => 'star',
                    'color' => 'amber',
                ],
                [
                    'title' => 'Kategori',
                    'value' => number_format($totalCategories),
                    'description' => 'Jenis proyek',
                    'icon' => 'tag',
                    'color' => 'purple',
                ],
                [
                    'title' => 'Klien',
                    'value' => number_format(Client::where('is_active', true)->count()),
                    'description' => 'Logo klien aktif',
                    'icon' => 'users',
                    'color' => 'indigo',
                ],
            ];
        });
    }

    private function getRecentProjects()
    {
        return Project::with('category:id,name')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'category' => $project->category?->name ?? 'Tanpa Kategori',
                    'status' => $project->status,
                    'is_featured' => $project->is_featured,
                    'created_at' => $project->created_at->diffForHumans(),
                    'featured_image_url' => $project->featured_image_url,
                ];
            });
    }

    private function getProjectsByCategory()
    {
        return ProjectCategory::withCount('projects')
            ->orderByDesc('projects_count')
            ->take(5)
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->projects_count,
                ];
            });
    }
}
