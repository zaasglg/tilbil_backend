<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::with('courses')->get();
        
        return response()->json([
            'success' => true,
            'data' => $levels
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ru' => 'required|string|max:255',
            'name_kk' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ru' => 'nullable|string',
            'description_kk' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $level = Level::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Level created successfully',
            'data' => $level
        ], 201);
    }

    public function show(Level $level)
    {
        $level->load('courses.lessons');
        
        return response()->json([
            'success' => true,
            'data' => $level
        ]);
    }

    public function update(Request $request, Level $level)
    {
        $request->validate([
            'name_ru' => 'required|string|max:255',
            'name_kk' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ru' => 'nullable|string',
            'description_kk' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $level->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Level updated successfully',
            'data' => $level
        ]);
    }

    public function destroy(Level $level)
    {
        $level->delete();

        return response()->json([
            'success' => true,
            'message' => 'Level deleted successfully'
        ]);
    }
}
