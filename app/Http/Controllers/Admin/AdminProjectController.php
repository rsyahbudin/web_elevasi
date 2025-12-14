<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Services\DataTablePaginationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminProjectController extends Controller
{
    public function __construct(private DataTablePaginationService $pagination)
    {
        // Using general permission for now
    }

    public function index(Request $request)
    {
        $perPage = $this->pagination->resolvePerPageWithDefaults($request);

        $projects = Project::query()
            ->with('category:id,name')
            ->latest()
            ->paginate($perPage)
            ->withQueryString()
            ->through(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'description' => Str::limit($project->description, 100),
                    'client_name' => $project->client_name,
                    'location' => $project->location,
                    'category' => $project->category,
                    'featured_image' => $project->featured_image,
                    'featured_image_url' => $project->featured_image_url,
                    'year_completed' => $project->year_completed,
                    'is_featured' => $project->is_featured,
                    'status' => $project->status,
                    'created_at_formatted' => $project->created_at_formatted,
                ];
            });

        $categories = ProjectCategory::select(['id', 'name'])->get();

        return Inertia::render('Admin/Project/IndexProjectPage', [
            'projects' => $projects,
            'categories' => $categories,
            'filters' => $this->pagination->buildFilters($request),
        ]);
    }

    public function create()
    {
        $categories = ProjectCategory::select(['id', 'name'])->get();

        return Inertia::render('Admin/Project/CreateProjectPage', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:project_categories,id'],
            'year_completed' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('projects', 'public');
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('projects', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        Project::create($validated);

        return redirect()->route('admin.project.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $project = Project::with('category:id,name')->findOrFail($id);
        $categories = ProjectCategory::select(['id', 'name'])->get();

        return Inertia::render('Admin/Project/EditProjectPage', [
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'slug' => $project->slug,
                'description' => $project->description,
                'client_name' => $project->client_name,
                'location' => $project->location,
                'category_id' => $project->category_id,
                'category' => $project->category,
                'featured_image' => $project->featured_image,
                'featured_image_url' => $project->featured_image_url,
                'images' => $project->images,
                'image_urls' => $project->image_urls,
                'year_completed' => $project->year_completed,
                'is_featured' => $project->is_featured,
                'status' => $project->status,
            ],
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:project_categories,id'],
            'year_completed' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'remove_featured_image' => ['boolean'],
            'existing_images' => ['nullable', 'array'],
        ]);

        // Handle remove featured image
        if ($request->boolean('remove_featured_image') && $project->featured_image) {
            Storage::disk('public')->delete($project->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($project->featured_image) {
                Storage::disk('public')->delete($project->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('projects', 'public');
        } elseif (!$request->boolean('remove_featured_image')) {
            unset($validated['featured_image']);
        }

        // Handle images - keep existing ones specified
        $existingImages = $request->input('existing_images', []);

        // Delete removed images
        if ($project->images) {
            foreach ($project->images as $oldImage) {
                if (!in_array($oldImage, $existingImages)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        }

        // Handle new images upload
        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $newImages[] = $image->store('projects', 'public');
            }
        }

        $validated['images'] = array_merge($existingImages, $newImages);

        unset($validated['remove_featured_image'], $validated['existing_images']);

        $project->update($validated);

        return redirect()->route('admin.project.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Soft delete - images will be kept
        $project->delete();

        return redirect()->route('admin.project.index')->with('success', 'Proyek berhasil dihapus.');
    }
}
