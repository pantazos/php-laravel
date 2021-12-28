<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ValidateUserRole;
use App\Http\Resources\Api\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AuthApiController extends Controller
{
    public const SANCTUM_APP_TOKEN = 'APP_TOKEN';

    /**
     * Create a new account for customers and generate a new token
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'phone_number' => 'required|string|unique:users'
        ]);

        // Check if firebase auth token is valid
        try {
            $uid = $this->validateFirebaseAuthToken($request);
        } catch (InvalidArgumentException $e) {
            return response(['message' => $e->getMessage()], 400);
        }

        $user = User::where('uid', $uid)->first();
        if ($user) {
            return response(['message' => 'This user already has an account'], 409);
        }

        // Create new user
        $user = new User([
            'uid' => $uid,
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'phone_number' => $fields['phone_number']
        ]);

        $roleKey = $request->header(ValidateUserRole::ROLE);
        $role = Role::byKey($roleKey)->first();
        $role->users()->save($user);

        // Generate new token
        $token = $user->createToken(self::SANCTUM_APP_TOKEN)->plainTextToken;
        $response = ['user' => new UserResource($user), 'token' => $token];

        return response($response, 201);
    }

    /**
     * Check firebase auth token and generate a new token for the user (customer or provider)
     */
    public function login(Request $request)
    {
        // Check if firebase auth token is valid
        try {
            $uid = $this->validateFirebaseAuthToken($request);
        } catch (InvalidArgumentException $e) {
            return response(['message' => $e->getMessage()], 400);
        }

        // Check if user exists
        $user = User::where('uid', $uid)->first();
        if (!$user) {
            return response(['message' => 'User not found'], 404); // User not found
        }

        $roleKey = $request->header(ValidateUserRole::ROLE);
        $role = Role::byKey($roleKey)->firstOrFail();
        $user->roles()->syncWithoutDetaching($role);

        // Generate a new token
        $token = $user->createToken("APP_TOKEN")->plainTextToken;
        $response = ['user' => new UserResource($user), 'token' => $token];

        return response($response);
    }

    /**
     * Deletes the current token for the authenticated user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $request->user()->update(['fcm_token' => null]);
        return response(['message' => 'Logged out']);
    }

    /**
     * Make an api call to firebase admin sdk to verify the auth token
     */
    private function validateFirebaseAuthToken(Request $request)
    {
        $request->validate(['firebase_auth_id_token' => 'required|string']);

        $firebaseAuthentication = Firebase::auth();
        $firebaseIdToken = $request->input('firebase_auth_id_token');
        $verifiedIdToken = $firebaseAuthentication->verifyIdToken($firebaseIdToken);

        return $verifiedIdToken->claims()->get('user_id');
    }
}
