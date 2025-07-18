<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function index()
    {
        return response()->json(Slider::paginate(5));
    }

    public function show($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($slider);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', 
        ], [
            'image.max' => 'The image may not be greater than 10MB.',
            'image.mimes' => 'Only jpeg, png, jpg, gif, and webp formats are allowed.',
        ]);

        if ($request->hasFile('image')) {
            if (!Storage::disk('public')->exists('uploads')) {
                Storage::disk('public')->makeDirectory('uploads');
            }

            $image = $request->file('image');
            $imageName = uniqid() . '.webp';
            $imagePath = 'uploads/' . $imageName;

            $manager = new ImageManager(new Driver());
            $webp = $manager->read($image)->toWebp(80);
            Storage::disk('public')->put($imagePath, (string) $webp);

            $validateData['image'] = "storage/$imagePath";
        }

        $slider = Slider::create($validateData);

        return response()->json([
            'id' => $slider->id,
            'image' => $slider->image,
            'message' => 'Slider created successfully',
            'success' => 200
        ]);
    }


    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $validateData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', 
        ], [
            'image.max' => 'The image may not be greater than 10MB.',
            'image.mimes' => 'Only jpeg, png, jpg, gif, and webp formats are allowed.',
        ]);

        if ($request->hasFile('image')) {
            if (!Storage::disk('public')->exists('uploads')) {
                Storage::disk('public')->makeDirectory('uploads');
            }

            if ($slider->image && Storage::disk('public')->exists(str_replace('storage/', '', $slider->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $slider->image));
            }

            $image = $request->file('image');
            $imageName = uniqid() . '.webp';
            $imagePath = 'uploads/' . $imageName;

            $manager = new ImageManager(new Driver());
            $webp = $manager->read($image)->toWebp(80);
            Storage::disk('public')->put($imagePath, (string) $webp);

            $validateData['image'] = "storage/$imagePath";
        }

        $slider->update([
            'title' => $validateData['title'] ?? $slider->title,
            'description' => $validateData['description'] ?? $slider->description,
            'image' => $validateData['image'] ?? $slider->image,
        ]);

        return response()->json([
            'id' => $slider->id,
            'image' => $slider->image,
            'message' => 'Slider updated successfully',
            'success' => 200
        ]);
    }


    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if ($slider->image) {
            $relativePath = str_replace('storage/', '', $slider->image);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $slider->delete();

        return response()->json([
            'id' => $slider->id,
            'message' => 'Slider deleted along with image',
            'status' => 200
        ]);
    }

    public function publicList()
    {
        return response()->json(Slider::orderBy('created_at', 'desc')->get());
    }
}
