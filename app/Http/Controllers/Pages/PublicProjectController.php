<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Inertia\Inertia;

class PublicProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->with('category:id,name,slug')
            ->published()
            ->latest()
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'description' => $project->description,
                    'client_name' => $project->client_name,
                    'location' => $project->location,
                    'category' => $project->category,
                    'featured_image_url' => $project->featured_image_url,
                    'year_completed' => $project->year_completed,
                    'is_featured' => $project->is_featured,
                ];
            });

        $categories = ProjectCategory::query()
            ->withCount([
                'projects' => function ($query) {
                    $query->published();
                },
            ])
            ->having('projects_count', '>', 0)
            ->get();

        $featuredProjects = $projects->where('is_featured', true)->take(6);

        return Inertia::render('Gallery', [
            'projects' => $projects,
            'categories' => $categories,
            'featuredProjects' => $featuredProjects,
        ]);
    }

    public function show($slug)
    {
        $project = Project::query()->with('category:id,name,slug')->published()->where('slug', $slug)->firstOrFail();

        // Get related projects from same category
        $relatedProjects = Project::query()
            ->with('category:id,name,slug')
            ->published()
            ->where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'featured_image_url' => $project->featured_image_url,
                    'category' => $project->category,
                ];
            });

        return Inertia::render('ProjectDetail', [
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'slug' => $project->slug,
                'description' => $project->description,
                'client_name' => $project->client_name,
                'location' => $project->location,
                'category' => $project->category,
                'featured_image_url' => $project->featured_image_url,
                'images' => $project->images,
                'image_urls' => $project->image_urls,
                'year_completed' => $project->year_completed,
            ],
            'relatedProjects' => $relatedProjects,
        ]);
    }
}
