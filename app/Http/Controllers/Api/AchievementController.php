<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::query();
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        $achievements = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $achievements
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:achievements',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_url' => 'nullable|string|max:255',
            'type' => 'required|in:single,streak,level,quiz_master,dictionary_hero',
            'criteria' => 'nullable|array',
        ]);

        $achievement = Achievement::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Achievement created successfully',
            'data' => $achievement
        ], 201);
    }

    public function show(Achievement $achievement)
    {
        return response()->json([
            'success' => true,
            'data' => $achievement
        ]);
    }

    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:achievements,code,' . $achievement->id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_url' => 'nullable|string|max:255',
            'type' => 'required|in:single,streak,level,quiz_master,dictionary_hero',
            'criteria' => 'nullable|array',
        ]);

        $achievement->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Achievement updated successfully',
            'data' => $achievement
        ]);
    }

    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Achievement deleted successfully'
        ]);
    }

    /**
     * Get user's achievements
     */
    public function userAchievements(Request $request)
    {
        $user = $request->user();
        
        $achievements = $user->achievements()->withPivot(['progress', 'completed_at'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $achievements
        ]);
    }

    /**
     * Award achievement to user
     */
    public function award(Request $request, Achievement $achievement)
    {
        $request->validate([
            'progress' => 'integer|min:0|max:100',
        ]);

        $user = $request->user();
        
        // Check if user already has this achievement
        if ($user->achievements()->where('achievement_id', $achievement->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'User already has this achievement'
            ], 400);
        }

        $progress = $request->get('progress', 100);
        $completedAt = $progress >= 100 ? now() : null;

        $user->achievements()->attach($achievement->id, [
            'progress' => $progress,
            'completed_at' => $completedAt
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Achievement awarded successfully',
            'data' => [
                'achievement' => $achievement,
                'progress' => $progress,
                'completed_at' => $completedAt
            ]
        ]);
    }

    /**
     * Update user achievement progress
     */
    public function updateProgress(Request $request, Achievement $achievement)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $user = $request->user();
        
        $pivot = $user->achievements()->where('achievement_id', $achievement->id)->first();
        
        if (!$pivot) {
            return response()->json([
                'success' => false,
                'message' => 'User does not have this achievement'
            ], 404);
        }

        $progress = $request->progress;
        $completedAt = $progress >= 100 ? now() : null;

        $user->achievements()->updateExistingPivot($achievement->id, [
            'progress' => $progress,
            'completed_at' => $completedAt
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Achievement progress updated successfully',
            'data' => [
                'achievement' => $achievement,
                'progress' => $progress,
                'completed_at' => $completedAt
            ]
        ]);
    }
}
