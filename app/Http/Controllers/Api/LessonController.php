<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $query = Lesson::with(['course.level']);
        
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        
        $lessons = $query->orderBy('order')->get();
        
        return response()->json([
            'success' => true,
            'data' => $lessons
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title_ru' => 'required|string|max:255',
            'title_kk' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'type' => 'required|in:text,video,audio,quiz,practice',
            'content_ru' => 'nullable|string',
            'content_kk' => 'nullable|string',
            'content_en' => 'nullable|string',
            'audio_url' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $lesson = Lesson::create($request->all());
        $lesson->load('course.level');

        return response()->json([
            'success' => true,
            'message' => 'Lesson created successfully',
            'data' => $lesson
        ], 201);
    }

    public function show(Lesson $lesson)
    {
        $lesson->load(['course.level']);
        
        return response()->json([
            'success' => true,
            'data' => $lesson
        ]);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title_ru' => 'required|string|max:255',
            'title_kk' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'type' => 'required|in:text,video,audio,quiz,practice',
            'content_ru' => 'nullable|string',
            'content_kk' => 'nullable|string',
            'content_en' => 'nullable|string',
            'audio_url' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $lesson->update($request->all());
        $lesson->load('course.level');

        return response()->json([
            'success' => true,
            'message' => 'Lesson updated successfully',
            'data' => $lesson
        ]);
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lesson deleted successfully'
        ]);
    }
}
