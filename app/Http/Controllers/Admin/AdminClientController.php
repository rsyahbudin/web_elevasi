<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Client/IndexClientPage', [
            'clients' => $clients,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $client = new Client();
        $client->name = $validated['name'];
        $client->website = $validated['website'] ?? null;
        $client->order = $validated['order'] ?? 0;
        $client->is_active = $validated['is_active'] ?? true;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('clients', 'public');
            $client->logo = $path;
        }

        $client->save();

        return redirect()->route('admin.client.index')->with('success', 'Klien berhasil ditambahkan');
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $client->name = $validated['name'];
        $client->website = $validated['website'] ?? null;
        $client->order = $validated['order'] ?? 0;
        $client->is_active = $validated['is_active'] ?? true;

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($client->logo) {
                Storage::disk('public')->delete($client->logo);
            }
            $path = $request->file('logo')->store('clients', 'public');
            $client->logo = $path;
        }

        $client->save();

        return redirect()->route('admin.client.index')->with('success', 'Klien berhasil diperbarui');
    }

    public function destroy(Client $client)
    {
        // Delete logo file
        if ($client->logo) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();

        return redirect()->route('admin.client.index')->with('success', 'Klien berhasil dihapus');
    }
}
