<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsitePiece;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class WebsitePieceController extends Controller
{
    public function index()
    {
        return response()->json(WebsitePiece::all());
    }

    public function show($type)
    {
        $piece = WebsitePiece::where('type', $type)->first();
        if (!$piece) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($piece);
    }


    public function store(Request $request)
    {
        return $this->saveOrUpdate($request);
    }

    public function update(Request $request, $id)
    {
        return $this->saveOrUpdate($request);
    }

    public function saveOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:about,welcome_note,mission,vision',
            'heading' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'home_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);


        $data = [
            'heading' => $validated['heading'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
        ];


        if (!Storage::disk('public')->exists('uploads')) {
            Storage::disk('public')->makeDirectory('uploads');
        }

        $manager = new \Intervention\Image\ImageManager(new GdDriver());


        if ($request->hasFile('home_image')) {
            $homeImage = $request->file('home_image');
            $homeImageName = uniqid() . '_home.webp';
            $homeImagePath = 'uploads/' . $homeImageName;

            $webp = $manager->read($homeImage)->toWebp(80);
            Storage::disk('public')->put($homeImagePath, (string) $webp);
            $data['home_image'] = "storage/$homeImagePath";
        }


        if ($request->hasFile('about_image')) {
            $aboutImage = $request->file('about_image');
            $aboutImageName = uniqid() . '_about.webp';
            $aboutImagePath = 'uploads/' . $aboutImageName;

            $webp = $manager->read($aboutImage)->toWebp(80);
            Storage::disk('public')->put($aboutImagePath, (string) $webp);
            $data['about_image'] = "storage/$aboutImagePath";
        }


        $piece = \App\Models\WebsitePiece::updateOrCreate(
            ['type' => $validated['type']],
            $data
        );

        return response()->json([
            'message' => 'Saved successfully',
            'data' => $piece
        ]);
    }



    public function publicList()
    {
        return response()->json(WebsitePiece::orderBy('created_at', 'desc')->get());
    }

    
}
