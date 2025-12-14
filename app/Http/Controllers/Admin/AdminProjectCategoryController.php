<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use App\Services\DataTablePaginationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminProjectCategoryController extends Controller
{
    public function __construct(private DataTablePaginationService $pagination)
    {
        // Using general permission for now
    }

    public function index(Request $request)
    {
        $perPage = $this->pagination->resolvePerPageWithDefaults($request);

        $categories = ProjectCategory::query()
            ->withCount([
                'projects' => function ($query) {
                    $query->where('status', 'published');
                },
            ])
            ->latest()
            ->paginate($perPage)
            ->withQueryString()
            ->through(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'projects_count' => $category->projects_count,
                    'created_at' => $category->created_at?->format('d M Y'),
                ];
            });

        return Inertia::render('Admin/Project/IndexCategoryPage', [
            'categories' => $categories,
            'filters' => $this->pagination->buildFilters($request),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:project_categories,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        ProjectCategory::create($validated);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $category = ProjectCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:project_categories,name,' . $id],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = ProjectCategory::findOrFail($id);

        // Check if category has projects
        if ($category->projects()->exists()) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki proyek.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
