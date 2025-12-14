<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        $featuredProjects = Project::query()
            ->with('category:id,name')
            ->published()
            ->featured()
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'featured_image_url' => $project->featured_image_url,
                    'category' => $project->category,
                    'location' => $project->location,
                ];
            });

        return Inertia::render('Home', [
            'featuredProjects' => $featuredProjects,
        ]);
    }

    public function terms()
    {
        return Inertia::render('Terms');
    }

    public function about()
    {
        return Inertia::render('About');
    }

    public function contact()
    {
        return Inertia::render('Contact');
    }
}
