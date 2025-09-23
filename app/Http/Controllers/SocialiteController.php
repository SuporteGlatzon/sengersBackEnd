<?php

namespace App\Http\Controllers;

use App\Services\SocialAccountsService;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Google_Client;
use Exception;

class SocialiteController extends Controller
{
    /**
     * Exchange an OAuth access token for a Laravel API token
     *
     * @param Request $request
     * @param SocialAccountsService $socialAccountsService
     * @return \Illuminate\Http\JsonResponse
     */
    public function oAuthToken(
        Request $request,
        SocialAccountsService $socialAccountsService
    ) {
        try {
            Log::info("oAuthToken request received", [
                "provider" => $request->get("provider"),
                "token_length" => strlen($request->get("access_token") ?? ""),
                "token_excerpt" =>
                    substr($request->get("access_token") ?? "", 0, 30) . "...",
                "headers" => $request->headers->all(),
            ]);

            $request->validate([
                "provider" => "required|in:google,linkedin-openid",
                "access_token" => "required",
            ]);

            $provider = $request->get("provider");
            $accessToken = $request->get("access_token");

            try {
                // Attempt to get user from provider using the token
                Log::info("Requesting user from {$provider}...");

                $providerUser = Socialite::driver($provider)
                    ->stateless()
                    ->userFromToken($accessToken);

                Log::info("Successfully retrieved user from {$provider}", [
                    "email" => $providerUser->getEmail(),
                    "id" => $providerUser->getId(),
                    "name" => $providerUser->getName(),
                ]);
            } catch (Exception $socialiteException) {
                Log::error(
                    "Error getting user with Socialite from {$provider}",
                    [
                        "error" => $socialiteException->getMessage(),
                        "token_start" => substr($accessToken, 0, 15) . "...",
                    ]
                );

                // Special handling for Google
                if ($provider === "google") {
                    try {
                        Log::info(
                            "Attempting alternative Google token verification"
                        );

                        // Try to verify as an ID token instead
                        $client = new Google_Client([
                            "client_id" => config("services.google.client_id"),
                        ]);
                        $payload = $client->verifyIdToken($accessToken);

                        if ($payload) {
                            Log::info("Successfully verified Google ID token", [
                                "email" => $payload["email"] ?? "not provided",
                                "sub" => $payload["sub"] ?? "not provided",
                            ]);

                            // Create a synthetic provider user
                            $providerUser = new class ($payload) {
                                private $payload;

                                public function __construct($payload)
                                {
                                    $this->payload = $payload;
                                }

                                public function getId()
                                {
                                    return $this->payload["sub"];
                                }

                                public function getName()
                                {
                                    return $this->payload["name"] ?? null;
                                }

                                public function getEmail()
                                {
                                    return $this->payload["email"] ?? null;
                                }

                                public function getAvatar()
                                {
                                    return $this->payload["picture"] ?? null;
                                }
                            };
                        } else {
                            throw new Exception(
                                "Failed to verify Google ID token"
                            );
                        }
                    } catch (Exception $googleException) {
                        Log::error(
                            "Alternative Google verification also failed",
                            [
                                "error" => $googleException->getMessage(),
                            ]
                        );

                        return response()->json(
                            [
                                "error" =>
                                    "Could not authenticate with Google. Please try again.",
                                "details" => $googleException->getMessage(),
                            ],
                            400
                        );
                    }
                } else {
                    return response()->json(
                        [
                            "error" => "Could not authenticate with {$provider}. Please try again.",
                            "details" => $socialiteException->getMessage(),
                        ],
                        400
                    );
                }
            }

            // Use service to find or create user
            Log::info("Finding or creating user account");
            $result = $socialAccountsService->findOrCreate(
                $providerUser,
                $provider
            );
            $user = $result["user"];

            Log::info("Authentication successful for {$user["email"]}");

            return response()->json([
                "access_token" => $result["access_token"],
                "token_type" => "Bearer",
                "expires_in" => 31536000,
                "user" => [
                    "id" => $user["id"],
                    "name" => $user["name"],
                    "email" => $user["email"],
                    "user_type" => $user["user_type"],
                    "avatar" => $user["avatar"],
                    "active" => $user["active"],
                ],
            ]);
        } catch (Exception $e) {
            Log::error("OAuth process error", [
                "message" => $e->getMessage(),
                "code" => $e->getCode(),
                "file" => $e->getFile(),
                "line" => $e->getLine(),
                "trace" => $e->getTraceAsString(),
            ]);

            return response()->json(
                [
                    "error" => "Authentication failed: {$e->getMessage()}",
                ],
                400
            );
        }
    }

    /**
     * Redirect to Google's OAuth provider
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogleProvider()
    {
        return Socialite::driver("google")->redirect();
    }

    /**
     * Handle Google's OAuth callback
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handlerGoogleProviderCallback()
    {
        try {
            $user = Socialite::driver("google")->user();
            Log::info("Google callback received user", [
                "email" => $user->getEmail(),
                "id" => $user->getId(),
            ]);

            return response()->json([
                "access_token" => $user->token,
                "user" => [
                    "id" => $user->getId(),
                    "name" => $user->getName(),
                    "email" => $user->getEmail(),
                    "avatar" => $user->getAvatar(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error("Google callback error", [
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
            ]);

            return response()->json(
                [
                    "error" => "Failed to authenticate with Google: {$e->getMessage()}",
                ],
                500
            );
        }
    }

    /**
     * Redirect to LinkedIn's OAuth provider
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function redirectToLinkedinProvider()
    {
        try {
            $user = Socialite::driver("linkedin-openid")->user();
            Log::info("LinkedIn redirect received user", [
                "email" => $user->getEmail(),
                "id" => $user->getId(),
            ]);

            return response()->json([
                "access_token" => $user->token,
                "user" => [
                    "id" => $user->getId(),
                    "name" => $user->getName(),
                    "email" => $user->getEmail(),
                    "avatar" => $user->getAvatar(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error("LinkedIn redirect error", [
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
            ]);

            return response()->json(
                [
                    "error" => "Failed to authenticate with LinkedIn: {$e->getMessage()}",
                ],
                500
            );
        }
    }

    /**
     * Handle LinkedIn's OAuth callback
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handlerLinkedinProviderCallback()
    {
        try {
            $user = Socialite::driver("linkedin-openid")->user();
            Log::info("LinkedIn callback received user", [
                "email" => $user->getEmail(),
                "id" => $user->getId(),
            ]);

            return response()->json([
                "access_token" => $user->token,
                "user" => [
                    "id" => $user->getId(),
                    "name" => $user->getName(),
                    "email" => $user->getEmail(),
                    "avatar" => $user->getAvatar(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error("LinkedIn callback error", [
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
            ]);

            return response()->json(
                [
                    "error" => "Failed to authenticate with LinkedIn: {$e->getMessage()}",
                ],
                500
            );
        }
    }
}
