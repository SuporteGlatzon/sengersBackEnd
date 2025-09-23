<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all users with pagination or other filters if needed
        $users = User::whereNull('deleted_at')->get();

        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    public function verifyEmail(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        if (!$user->active) {
            return response()->json(['error' => 'Usuário não está ativo'], 403);
        }

        return response()->json(['message' => 'Usuário verificado e ativo'], 200);
    }
}
