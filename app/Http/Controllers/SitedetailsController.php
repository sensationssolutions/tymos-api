<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sitedetails;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class SitedetailsController extends Controller
{
    public function index()
    {
        return response()->json(Sitedetails::first());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'phone1' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $validated;

        if (!Storage::disk('public')->exists('uploads')) {
            Storage::disk('public')->makeDirectory('uploads');
        }

        $manager = new ImageManager(new GdDriver());

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = uniqid() . '_logo.webp';
            $path = 'uploads/' . $filename;
            $webp = $manager->read($file)->toWebp(80);
            Storage::disk('public')->put($path, (string) $webp);
            $data['logo'] = "storage/$path";
        }

        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = uniqid() . '_favicon.webp';
            $path = 'uploads/' . $filename;
            $webp = $manager->read($file)->toWebp(80);
            Storage::disk('public')->put($path, (string) $webp);
            $data['favicon'] = "storage/$path";
        }

        
        $sitedetails = Sitedetails::updateOrCreate(['id' => 1], $data);

        return response()->json([
            'message' => 'Site details saved successfully.',
            'data' => $sitedetails
        ]);
    }

    public function publicView()
    {
        return response()->json(Sitedetails::first());
    }
}
