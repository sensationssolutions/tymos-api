<?php


namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        return response()->json(Career::all());
    }

    public function store(Request $request)
    {
        $career = Career::create($request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]));

        return response()->json($career, 201);
    }

    public function show($id)
    {
        $career = Career::find($id);
        if (!$career) return response()->json(['message' => 'Not found'], 404);
        return response()->json($career);
    }

    public function update(Request $request, $id)
    {
        $career = Career::find($id);
        if (!$career) return response()->json(['message' => 'Not found'], 404);

        $career->update($request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]));

        return response()->json($career);
    }

    public function destroy($id)
    {
        $career = Career::find($id);
        if (!$career) return response()->json(['message' => 'Not found'], 404);

        $career->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}

