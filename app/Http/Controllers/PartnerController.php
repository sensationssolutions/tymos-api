<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); 
        $perPage = min($perPage, 100); 

        return response()->json(Partner::latest()->paginate($perPage));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = uniqid() . '.webp';
        $imagePath = 'uploads/partners/' . $imageName;

        $manager = new ImageManager(new GdDriver());
        $webpImage = $manager->read($image)->toWebp(85);
        Storage::disk('public')->put($imagePath, (string) $webpImage);

        $partner = Partner::create([
            'image_url' => "storage/$imagePath",
        ]);

        return response()->json([
            'message' => 'Partner added successfully',
            'id' => $partner->id,
            'status' => 200,
        ]);
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        if ($partner->image_url) {
            $relativePath = str_replace('storage/', '', $partner->image_url);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $partner->delete();

        return response()->json([
            'message' => 'Partner deleted successfully',
            'status' => 200,
        ]);
    }


    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($partner->image_url) {
                $relativePath = str_replace('storage/', '', $partner->image_url);
                if (Storage::disk('public')->exists($relativePath)) {
                    Storage::disk('public')->delete($relativePath);
                }
            }


            $image = $request->file('image');
            $imageName = uniqid() . '.webp';
            $imagePath = 'uploads/partners/' . $imageName;

            $manager = new ImageManager(new GdDriver());
            $webpImage = $manager->read($image)->toWebp(85);
            Storage::disk('public')->put($imagePath, (string) $webpImage);

            $partner->image_url = "storage/$imagePath";
        }

        $partner->save();

        return response()->json([
            'message' => 'Partner updated successfully',
            'status' => 200,
        ]);
    }



    public function show($id)
    {
        return response()->json(Partner::findOrFail($id));
    }

    public function publicList()
    {
        return response()->json(Partner::latest()->get());
    }
}
