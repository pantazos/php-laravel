<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\Category;
use App\Models\NotificationToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersApiController extends Controller
{
    /**
     * Update user details
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request): Response
    {
        $user = $request->user();
        $user->update($request->only('first_name', 'last_name', 'email'));
        return response(new UserResource($user));
    }

    /**
     * Update user FCM token
     *
     * @param Request $request
     * @return Response
     */
    public function registerFCMToken(Request $request): Response
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);

        $token = new NotificationToken(['token' => $request->input('fcm_token')]);
        $request->user()->notificationTokens()->save($token);
        return response(['message' => "Updated successfully"]);
    }

    /**
     * Update provider categories
     *
     * @param Request $request
     * @return Response
     */
    public function updateCategories(Request $request): Response
    {
        $request->validate(['categories' => 'required|string']);
        $categoryKeys = explode(',', $request->input('categories'));
        $categoryIds = Category::whereIn('key', $categoryKeys)
            ->get()
            ->map(function ($category) {
                return $category->id;
            });

        $user = $request->user();
        $user->categories()->sync($categoryIds);

        return response(new UserResource($user));
    }
}
