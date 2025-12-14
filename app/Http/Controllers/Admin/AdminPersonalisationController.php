<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personalisation;
use App\Traits\PersonalisationsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminPersonalisationController extends Controller
{
    use PersonalisationsHelper;

    public function __construct()
    {
        $this->middleware('permission:view-personalisation');
    }

    public function index()
    {
        $personalisation = $this->getPersonalisations();

        return Inertia::render('Admin/Personalisation/IndexPage', [
            'personalisation' => $personalisation,
        ]);
    }

    public function updateInfo(Request $request)
    {
        $this->authorize('update-personalisation');

        $validated = $request->validate([
            'app_name' => ['nullable', 'string', 'max:100'],
            'copyright_text' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'string', 'email', 'max:100'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $personalisation = Personalisation::firstOrCreate();

        $personalisation->update($validated);

        return redirect()->back()->with('success', __('notifications.admin.settings_updated_successfully'));
    }

    public function upload(Request $request)
    {
        $this->authorize('upload-personalisation-files');

        $request->validate([
            'app_logo' => ['nullable', 'image', 'max:2048'],
            'app_logo_dark' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'file', 'mimes:png,ico', 'max:2048'],
        ]);

        if ($request->hasFile('app_logo') || $request->hasFile('app_logo_dark') || $request->hasFile('favicon')) {
            $field = $request->hasFile('app_logo')
                ? 'app_logo'
                : ($request->hasFile('app_logo_dark')
                    ? 'app_logo_dark'
                    : 'favicon');

            $file = $request->file($field);
            $fileName = time() . '_' . $file->getClientOriginalName();

            $path = $request->file($field)->storeAs('personalisation', $fileName, 'public');

            $personalisation = Personalisation::firstOrCreate();

            if ($personalisation->$field) {
                if (Storage::disk('public')->exists($personalisation->$field)) {
                    Storage::disk('public')->delete($personalisation->$field);
                }
            }

            $personalisation->update([$field => $path]);

            return response()->json(['path' => Storage::url($path)]);
        }

        return response()->json(['error' => __('notifications.errors.no_file_uploaded')], 400);
    }

    public function delete(Request $request)
    {
        $this->authorize('delete-personalisation-files');

        $request->validate([
            'field' => ['required', 'string', 'in:app_logo,app_logo_dark,favicon'],
            'path' => ['nullable', 'string'],
        ]);

        $field = $request->input('field');
        $pathToDelete = $request->input('path');

        \Log::info('Delete request received', ['field' => $field, 'path_input' => $pathToDelete]);

        // Normalize path: remove /storage/ prefix to match DB format
        if ($pathToDelete) {
            $pathToDelete = str_replace('/storage/', '', $pathToDelete);
            $pathToDelete = ltrim($pathToDelete, '/');
        }

        $personalisation = Personalisation::first();

        if ($personalisation && $personalisation->$field) {
            \Log::info('Current DB value', ['db_value' => $personalisation->$field]);

            // STRICT SAFETY:
            // If pathToDelete is NOT provided, we cannot be sure what the user intends to delete.
            // To be safe, we DO NOT clear the DB. We only clear DB if we are explicitly deleting the CURRENT file.
            if (!$pathToDelete) {
                \Log::warning('Delete blocked: No path provided');
                return response()->json(['success' => false, 'message' => 'Path required to delete']);
            }

            if ($personalisation->$field !== $pathToDelete) {
                \Log::info('Delete DB skipped: Path mismatch', [
                    'db' => $personalisation->$field,
                    'target' => $pathToDelete,
                ]);

                // We might still want to delete the physical file if it exists (garbage collection)
                // But we definitely preserve the DB record of the NEW logo.
                if (Storage::disk('public')->exists($pathToDelete)) {
                    Storage::disk('public')->delete($pathToDelete);
                    \Log::info('Old file deleted from storage', ['path' => $pathToDelete]);
                }

                return response()->json(['success' => true, 'message' => 'Old file removed, DB preserved']);
            }

            // Path matches DB exactly: This is a legitimate removal of the current logo.
            if (Storage::disk('public')->exists($personalisation->$field)) {
                Storage::disk('public')->delete($personalisation->$field);
            }
            $personalisation->update([$field => null]);
            \Log::info('DB cleared', ['field' => $field]);
        } else {
            \Log::info('Delete skipped: DB field already empty');
        }

        return response()->json(['success' => true]);
    }
}
