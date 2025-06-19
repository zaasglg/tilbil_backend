<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Handle Google OAuth for mobile apps using access token
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleAuth(Request $request)
    {
        try {
            $request->validate([
                'access_token' => 'required|string',
            ]);

            // Get user info from Google using the access token
            $response = Http::get('https://www.googleapis.com/oauth2/v2/userinfo', [
                'access_token' => $request->access_token
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Google access token'
                ], 401);
            }

            $googleUser = $response->json();

            if (!isset($googleUser['id']) || !isset($googleUser['email'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Google user data'
                ], 401);
            }

            // Check if user already exists by Google ID
            $user = User::where('google_id', $googleUser['id'])->first();

            if (!$user) {
                // Check if user exists by email
                $user = User::where('email', $googleUser['email'])->first();
                
                if ($user) {
                    // Link existing account with Google
                    $user->update([
                        'google_id' => $googleUser['id'],
                        'avatar_url' => $googleUser['picture'] ?? null,
                        'email_verified_at' => now(),
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $googleUser['name'] ?? $googleUser['email'],
                        'email' => $googleUser['email'],
                        'google_id' => $googleUser['id'],
                        'avatar_url' => $googleUser['picture'] ?? null,
                        'password' => Hash::make(Str::random(24)), // Random password
                        'email_verified_at' => now(),
                    ]);
                }
            } else {
                // Update existing Google user info
                $user->update([
                    'name' => $googleUser['name'] ?? $user->name,
                    'email' => $googleUser['email'],
                    'avatar_url' => $googleUser['picture'] ?? $user->avatar_url,
                    'email_verified_at' => now(),
                ]);
            }

            // Create API token
            $token = $user->createToken('google_auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Google authentication successful',
                'data' => [
                    'user' => $user->makeHidden(['password']),
                    'token' => $token,
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Google authentication failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle Google OAuth with ID token (recommended for mobile)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleIdToken(Request $request)
    {
        try {
            $request->validate([
                'id_token' => 'required|string',
            ]);

            // Verify Google ID token by calling Google's tokeninfo endpoint
            $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $request->id_token
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Google ID token'
                ], 401);
            }

            $payload = $response->json();

            // Verify that the token is for our client
            if ($payload['aud'] !== config('services.google.client_id')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Google ID token audience'
                ], 401);
            }

            $googleId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'] ?? $email;
            $avatar = $payload['picture'] ?? null;
            $emailVerified = $payload['email_verified'] ?? false;

            // Check if user already exists by Google ID
            $user = User::where('google_id', $googleId)->first();

            if (!$user) {
                // Check if user exists by email
                $user = User::where('email', $email)->first();
                
                if ($user) {
                    // Link existing account with Google
                    $user->update([
                        'google_id' => $googleId,
                        'avatar_url' => $avatar,
                        'email_verified_at' => $emailVerified ? now() : $user->email_verified_at,
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $name,
                        'email' => $email,
                        'google_id' => $googleId,
                        'avatar_url' => $avatar,
                        'password' => Hash::make(Str::random(24)), // Random password
                        'email_verified_at' => $emailVerified ? now() : null,
                    ]);
                }
            } else {
                // Update existing Google user info
                $user->update([
                    'name' => $name,
                    'email' => $email,
                    'avatar_url' => $avatar,
                    'email_verified_at' => $emailVerified ? now() : $user->email_verified_at,
                ]);
            }

            // Create API token
            $token = $user->createToken('google_auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Google authentication successful',
                'data' => [
                    'user' => $user->makeHidden(['password']),
                    'token' => $token,
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Google authentication failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unlink Google account from user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlinkGoogle(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user->google_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google account is not linked'
                ], 400);
            }

            // Check if user has a password (to ensure they can still log in)
            if (!$user->password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot unlink Google account. Please set a password first.'
                ], 400);
            }

            $user->update([
                'google_id' => null,
                'avatar_url' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Google account unlinked successfully'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to unlink Google account',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}