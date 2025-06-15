<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::with(['lesson.course.level']);
        
        if ($request->has('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }
        
        $quizzes = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $quizzes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple,single,true_false,input',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required|string',
        ]);

        $quiz = Quiz::create($request->all());
        $quiz->load('lesson.course.level');

        return response()->json([
            'success' => true,
            'message' => 'Quiz created successfully',
            'data' => $quiz
        ], 201);
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['lesson.course.level']);
        
        return response()->json([
            'success' => true,
            'data' => $quiz
        ]);
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple,single,true_false,input',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required|string',
        ]);

        $quiz->update($request->all());
        $quiz->load('lesson.course.level');

        return response()->json([
            'success' => true,
            'message' => 'Quiz updated successfully',
            'data' => $quiz
        ]);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quiz deleted successfully'
        ]);
    }

    /**
     * Submit quiz answer and return if correct
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $isCorrect = $quiz->correct_answer === $request->answer;

        return response()->json([
            'success' => true,
            'data' => [
                'correct' => $isCorrect,
                'correct_answer' => $quiz->correct_answer,
                'submitted_answer' => $request->answer
            ]
        ]);
    }
}
