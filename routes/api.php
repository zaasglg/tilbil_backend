<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\VocabularyController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\UserProgressController;
use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\GoogleAuthController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Google OAuth routes
Route::post('/auth/google', [GoogleAuthController::class, 'handleGoogleAuth']);
Route::post('/auth/google/id-token', [GoogleAuthController::class, 'handleGoogleIdToken']);

// Public read-only routes for learning content
Route::get('/levels', [LevelController::class, 'index']);
Route::get('/levels/{level}', [LevelController::class, 'show']);
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{course}', [CourseController::class, 'show']);
Route::get('/lessons', [LessonController::class, 'index']);
Route::get('/lessons/{lesson}', [LessonController::class, 'show']);
Route::get('/vocabulary', [VocabularyController::class, 'index']);
Route::get('/vocabulary/{vocabulary}', [VocabularyController::class, 'show']);
Route::get('/quizzes', [QuizController::class, 'index']);
Route::get('/quizzes/{quiz}', [QuizController::class, 'show']);
Route::get('/achievements', [AchievementController::class, 'index']);
Route::get('/achievements/{achievement}', [AchievementController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('/user', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    
    // Google OAuth routes
    Route::post('/auth/google/unlink', [GoogleAuthController::class, 'unlinkGoogle']);
    
    // User Progress routes
    Route::get('/progress', [UserProgressController::class, 'index']);
    Route::post('/progress', [UserProgressController::class, 'store']);
    Route::get('/progress/{userProgress}', [UserProgressController::class, 'show']);
    Route::put('/progress/{userProgress}', [UserProgressController::class, 'update']);
    Route::delete('/progress/{userProgress}', [UserProgressController::class, 'destroy']);
    Route::get('/progress/stats', [UserProgressController::class, 'stats']);
    
    // Quiz submission
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit']);
    
    // User Achievements
    Route::get('/user/achievements', [AchievementController::class, 'userAchievements']);
    Route::post('/achievements/{achievement}/award', [AchievementController::class, 'award']);
    Route::put('/achievements/{achievement}/progress', [AchievementController::class, 'updateProgress']);
    
    // Admin-only routes (for content management)
    Route::middleware('can:admin')->group(function () {
        // Levels
        Route::post('/levels', [LevelController::class, 'store']);
        Route::put('/levels/{level}', [LevelController::class, 'update']);
        Route::delete('/levels/{level}', [LevelController::class, 'destroy']);
        
        // Courses
        Route::post('/courses', [CourseController::class, 'store']);
        Route::put('/courses/{course}', [CourseController::class, 'update']);
        Route::delete('/courses/{course}', [CourseController::class, 'destroy']);
        
        // Lessons
        Route::post('/lessons', [LessonController::class, 'store']);
        Route::put('/lessons/{lesson}', [LessonController::class, 'update']);
        Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy']);
        
        // Vocabulary
        Route::post('/vocabulary', [VocabularyController::class, 'store']);
        Route::put('/vocabulary/{vocabulary}', [VocabularyController::class, 'update']);
        Route::delete('/vocabulary/{vocabulary}', [VocabularyController::class, 'destroy']);
        
        // Quizzes
        Route::post('/quizzes', [QuizController::class, 'store']);
        Route::put('/quizzes/{quiz}', [QuizController::class, 'update']);
        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy']);
        
        // Achievements
        Route::post('/achievements', [AchievementController::class, 'store']);
        Route::put('/achievements/{achievement}', [AchievementController::class, 'update']);
        Route::delete('/achievements/{achievement}', [AchievementController::class, 'destroy']);
    });
});
