<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function index(Request $request)
    {
        $query = Vocabulary::with(['lesson.course.level']);
        
        if ($request->has('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }
        
        $vocabulary = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $vocabulary
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'word_kz' => 'required|string|max:255',
            'word_ru' => 'required|string|max:255',
            'word_en' => 'required|string|max:255',
            'transcription' => 'nullable|string|max:255',
            'audio_url' => 'nullable|string|max:255',
            'examples_kz' => 'nullable|array',
            'examples_ru' => 'nullable|array',
            'examples_en' => 'nullable|array',
        ]);

        $vocabulary = Vocabulary::create($request->all());
        $vocabulary->load('lesson.course.level');

        return response()->json([
            'success' => true,
            'message' => 'Vocabulary created successfully',
            'data' => $vocabulary
        ], 201);
    }

    public function show(Vocabulary $vocabulary)
    {
        $vocabulary->load(['lesson.course.level']);
        
        return response()->json([
            'success' => true,
            'data' => $vocabulary
        ]);
    }

    public function update(Request $request, Vocabulary $vocabulary)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'word_kz' => 'required|string|max:255',
            'word_ru' => 'required|string|max:255',
            'word_en' => 'required|string|max:255',
            'transcription' => 'nullable|string|max:255',
            'audio_url' => 'nullable|string|max:255',
            'examples_kz' => 'nullable|array',
            'examples_ru' => 'nullable|array',
            'examples_en' => 'nullable|array',
        ]);

        $vocabulary->update($request->all());
        $vocabulary->load('lesson.course.level');

        return response()->json([
            'success' => true,
            'message' => 'Vocabulary updated successfully',
            'data' => $vocabulary
        ]);
    }

    public function destroy(Vocabulary $vocabulary)
    {
        $vocabulary->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vocabulary deleted successfully'
        ]);
    }
}
