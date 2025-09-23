<?php

namespace App\Services;

use App\Models\Role;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
// Remove the specific type hint:
// use Laravel\Socialite\Two\User as ProviderUser;

class SocialAccountsService
{
    // Change the type hint to allow any object:
    public function findOrCreate($providerUser, string $provider)
    {
        Log::info("Checking if user already exists", [
            "provider" => $provider,
            "provider_id" => $providerUser->getId(),
            "email" => $providerUser->getEmail(),
        ]);

        // The rest of your code stays the same
        $socialAccount = SocialAccount::where("provider_name", $provider)
            ->where("provider_id", $providerUser->getId())
            ->first();

        if ($socialAccount) {
            \Illuminate\Support\Facades\Log::info("Social account found", [
                "user_id" => $socialAccount->user_id,
            ]);
            $user = $socialAccount->user()->withTrashed()->first();

            if ($user->deleted_at) {
                Log::warning("Restoring soft-deleted user", [
                    "email" => $user->email,
                ]);
                $user->restore();
            }

            if (!$user->active) {
                Log::error("User account is inactive", [
                    "email" => $user->email,
                ]);
                throw ValidationException::withMessages([
                    "user" => [
                        "Your account is inactive. Please contact support.",
                    ],
                ])->status(Response::HTTP_FORBIDDEN);
            }

            return $this->getAccessToken($user, $provider, $providerUser);
        }

        // If social account does not exist, check by email
        $email = $providerUser->getEmail();
        $user = $email
            ? User::withTrashed()->where("email", $email)->first()
            : null;

        if ($user) {
            if ($user->deleted_at) {
                Log::warning("Restoring soft-deleted user", [
                    "email" => $user->email,
                ]);
                $user->restore();
            }

            if (!$user->active) {
                Log::error("User is inactive", ["user_id" => $user->id]);
                throw ValidationException::withMessages([
                    "user" => [
                        "Your account is inactive. Please contact support.",
                    ],
                ])->status(Response::HTTP_FORBIDDEN);
            }
        } else {
            Log::info("Creating a new user for:", ["email" => $email]);

            // Create a new user
            $user = User::create([
                "name" => $providerUser->getName(),
                "email" => $email,
                "role_id" => Role::CLIENT,
                "user_type" => "client",
                "avatar" => $providerUser->getAvatar(),
                "active" => true, // Default active
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // Create social account link
        $user->socialAccounts()->firstOrCreate([
            "provider_id" => $providerUser->getId(),
            "provider_name" => $provider,
        ]);

        return $this->getAccessToken($user, $provider, $providerUser);
    }

    private function getAccessToken($user, $provider, $providerUser)
    {
        if ($user->deleted_at) {
            throw ValidationException::withMessages([
                "user" => ["User Deleted"],
            ])->status(Response::HTTP_NOT_FOUND);
        }

        // Ensure the user has a name & avatar
        if ($providerUser) {
            $user->avatar = $providerUser->getAvatar();
            $user->name = $providerUser->getName() ?? $user->name;
            $user->save();
        }

        // Prevent token revocation if no tokens exist
        if ($user->tokens()->count() > 0) {
            $user->tokens()->each(fn($token) => $token->revoke());
        }

        // Generate a new token
        $token = $user->createToken("token-" . $provider)->accessToken;

        Log::info("OAuth token generated successfully", [
            "user_id" => $user->id,
        ]);

        return [
            "access_token" => $token,
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "user_type" => $user->user_type,
                "avatar" => $user->avatar,
                "active" => $user->active,
            ],
        ];
    }
}
