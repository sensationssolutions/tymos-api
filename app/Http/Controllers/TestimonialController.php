<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return response()->json(Testimonial::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/testimonials', 'public');
            $validated['image_url'] = "storage/$imagePath";
        }

        $testimonial = Testimonial::create($validated);

        return response()->json([
            'id' => $testimonial->id,
            'message' => 'Testimonial created',
            'success' => 200,
        ]);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($testimonial->image_url) {
                $relativePath = str_replace('storage/', '', $testimonial->image_url);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            }

            $imagePath = $request->file('image')->store('uploads/testimonials', 'public');
            $validated['image_url'] = "storage/$imagePath";
        }

        $testimonial->update($validated);

        return response()->json([
            'message' => 'Testimonial updated',
            'success' => 200,
        ]);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->image_url) {
            $relativePath = str_replace('storage/', '', $testimonial->image_url);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $testimonial->delete();

        return response()->json([
            'message' => 'Testimonial deleted',
            'status' => 200,
        ]);
    }

    public function show($id)
    {
        return response()->json(Testimonial::findOrFail($id));
    }

    public function publicList() {
        return response()->json(Testimonial::orderBy('created_at', 'desc')->get());
    }

}
