<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class UserProgressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = UserProgress::with(['level', 'course', 'lesson'])
            ->where('user_id', $user->id);
        
        if ($request->has('level_id')) {
            $query->where('level_id', $request->level_id);
        }
        
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $progress = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $progress
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessons,id',
            'status' => 'required|in:not_started,in_progress,completed',
            'score' => 'integer|min:0|max:100',
        ]);

        $user = $request->user();
        
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $request->lesson_id
            ],
            $request->only(['level_id', 'course_id', 'status', 'score'])
        );

        $progress->load(['level', 'course', 'lesson']);

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'data' => $progress
        ], 201);
    }

    public function show(Request $request, UserProgress $userProgress)
    {
        // Ensure user can only access their own progress
        if ($userProgress->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $userProgress->load(['level', 'course', 'lesson']);
        
        return response()->json([
            'success' => true,
            'data' => $userProgress
        ]);
    }

    public function update(Request $request, UserProgress $userProgress)
    {
        // Ensure user can only update their own progress
        if ($userProgress->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'status' => 'required|in:not_started,in_progress,completed',
            'score' => 'integer|min:0|max:100',
        ]);

        $userProgress->update($request->only(['status', 'score']));
        $userProgress->load(['level', 'course', 'lesson']);

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'data' => $userProgress
        ]);
    }

    public function destroy(Request $request, UserProgress $userProgress)
    {
        // Ensure user can only delete their own progress
        if ($userProgress->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $userProgress->delete();

        return response()->json([
            'success' => true,
            'message' => 'Progress deleted successfully'
        ]);
    }

    /**
     * Get user's overall progress statistics
     */
    public function stats(Request $request)
    {
        $user = $request->user();
        
        $stats = [
            'total_lessons' => UserProgress::where('user_id', $user->id)->count(),
            'completed_lessons' => UserProgress::where('user_id', $user->id)
                ->where('status', 'completed')->count(),
            'in_progress_lessons' => UserProgress::where('user_id', $user->id)
                ->where('status', 'in_progress')->count(),
            'average_score' => UserProgress::where('user_id', $user->id)
                ->where('status', 'completed')->avg('score'),
        ];

        $stats['completion_percentage'] = $stats['total_lessons'] > 0 
            ? round(($stats['completed_lessons'] / $stats['total_lessons']) * 100, 2)
            : 0;

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
