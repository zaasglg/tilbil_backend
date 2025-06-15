<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['level', 'lessons']);
        
        if ($request->has('level_id')) {
            $query->where('level_id', $request->level_id);
        }
        
        $courses = $query->orderBy('order')->get();
        
        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        $course = Course::create($request->all());
        $course->load('level');

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);
    }

    public function show(Course $course)
    {
        $course->load(['level', 'lessons' => function($query) {
            $query->orderBy('order');
        }]);
        
        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        $course->update($request->all());
        $course->load('level');

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $course
        ]);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }
}
