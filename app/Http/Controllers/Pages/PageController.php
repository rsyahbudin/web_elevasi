<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Client;
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

        $clients = Client::active()
            ->ordered()
            ->get()
            ->map(function ($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'logo_url' => $client->logo_url,
                    'website' => $client->website,
                ];
            });

        return Inertia::render('Home', [
            'featuredProjects' => $featuredProjects,
            'clients' => $clients,
        ]);
    }

    public function terms()
    {
        return Inertia::render('Terms');
    }

    public function about()
    {
        $clients = Client::active()
            ->ordered()
            ->get()
            ->map(function ($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'logo_url' => $client->logo_url,
                    'website' => $client->website,
                ];
            });

        return Inertia::render('About', [
            'clients' => $clients,
        ]);
    }

    public function contact()
    {
        return Inertia::render('Contact');
    }
}
