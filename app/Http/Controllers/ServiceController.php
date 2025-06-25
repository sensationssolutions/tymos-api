<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(5); 
        return response()->json($services);
    }

    public function show($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($service);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            if (!Storage::disk('public')->exists('uploads')) {
                Storage::disk('public')->makeDirectory('uploads');
            }

            $image = $request->file('image');
            $imageName = uniqid() . '.webp';
            $imagePath = 'uploads/' . $imageName;

            // Convert to WebP using Intervention Image
            $manager = new ImageManager(new GdDriver());
            $webpImage = $manager->read($image)->toWebp(80); // 80% quality
            Storage::disk('public')->put($imagePath, (string) $webpImage);

            $validateData['image_url'] = "storage/$imagePath";
        }

        $service = Service::create([
            'image_url' => $validateData['image_url'] ?? null,
            'title' => $validateData['title'] ?? null,
            'content' => $validateData['content'] ?? null,
        ]);

        return response()->json([
            'id' => $service->id,
            'image_url' => $service->image_url,
            'message' => 'Service created successfully',
            'success' => 200
        ]);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validateData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            if (!Storage::disk('public')->exists('uploads')) {
                Storage::disk('public')->makeDirectory('uploads');
            }

            // Delete old image if exists
            if ($service->image_url && Storage::disk('public')->exists(str_replace('storage/', '', $service->image_url))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $service->image_url));
            }

            $image = $request->file('image');
            $imageName = uniqid() . '.webp';
            $imagePath = 'uploads/' . $imageName;

            // Convert to WebP using Intervention Image
            $manager = new ImageManager(new GdDriver());
            $webpImage = $manager->read($image)->toWebp(80);
            Storage::disk('public')->put($imagePath, (string) $webpImage);

            $validateData['image_url'] = "storage/$imagePath";
        }

        $service->update([
            'image_url' => $validateData['image_url'] ?? $service->image_url,
            'title' => $validateData['title'] ?? $service->title,
            'content' => $validateData['content'] ?? $service->content,
        ]);

        return response()->json([
            'id' => $service->id,
            'image_url' => $service->image_url,
            'message' => 'Service updated successfully',
            'success' => 200
        ]);
    }

    public function destroy($contactId)
    {
        $service = Service::findOrFail($contactId);

        if ($service->image_url) {
            $relativePath = str_replace('storage/', '', $service->image_url);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $service->delete();

        return response()->json([
            'id' => $service->id,
            'message' => 'Service deleted along with image',
            'status' => 200
        ]);
    }

    public function publicList()
    {
        return response()->json(Service::orderBy('created_at', 'desc')->get());
    }
}