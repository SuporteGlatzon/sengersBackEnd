<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntegratorSectionController;
use App\Http\Controllers\OccupationAreaController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\OpportunityTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController; 
use App\Http\Controllers\HomeAssociateController; // ✅ import
use App\Http\Controllers\HomeBookRoomController; // ✅ import
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui você registra as rotas da API.
| Todas são carregadas pelo RouteServiceProvider e recebem o prefixo /api
|
*/

Route::prefix("auth")->group(function () {
    Route::post("/oauth/token", [SocialiteController::class, "oAuthToken"]);
    Route::get("/google/redirect", [
        SocialiteController::class,
        "redirectToGoogleProvider",
    ]);
    Route::get("/google/callback", [
        SocialiteController::class,
        "handlerGoogleProviderCallback",
    ]);
    Route::get("/linkedin/redirect", [
        SocialiteController::class,
        "redirectToLinkedinProvider",
    ]);
    Route::get("/linkedin/callback", [
        SocialiteController::class,
        "handlerLinkedinProviderCallback",
    ]);
});

// Authenticated routes with middleware
Route::group(["middleware" => ["auth:api", "throttle:60,1"]], function () {
    Route::get("profile", [ProfileController::class, "index"]);
    Route::put("profile", [ProfileController::class, "update"]);
    Route::post("profile/opportunity", [
        ProfileController::class,
        "opportunity_store",
    ]);
    Route::post("profile/opportunity/{opportunity_id}/viewed", [
        ProfileController::class,
        "opportunity_viewed",
    ]);
    Route::get("profile/opportunities-applied/{opportunity_id}", [
        ProfileController::class,
        "opportunity_applied_show",
    ]);
    Route::get("profile/opportunity/{opportunity_id}", [
        ProfileController::class,
        "opportunity_show",
    ]);
    Route::put("profile/opportunity/{opportunity_id}", [
        ProfileController::class,
        "opportunity_update",
    ]);
    Route::delete("profile/opportunity/{opportunity_id}", [
        ProfileController::class,
        "opportunity_delete",
    ]);
    Route::post("profile/opportunity/{opportunity_id}/associate", [
        ProfileController::class,
        "opportunity_associate",
    ]);
    Route::delete("profile/opportunity/{opportunity_id}/associate", [
        ProfileController::class,
        "opportunity_disassociate",
    ]);

    Route::post("profile/education", [
        ProfileController::class,
        "education_store",
    ]);
    Route::put("profile/education/{education_id}", [
        ProfileController::class,
        "education_update",
    ]);
    Route::delete("profile/education/{education_id}", [
        ProfileController::class,
        "education_delete",
    ]);

    Route::post("opportunity-type", [
        OpportunityTypeController::class,
        "store",
    ]);
    Route::put("opportunity-type/{opportunity_type_id}", [
        OpportunityTypeController::class,
        "update",
    ]);
    Route::delete("opportunity-type/{opportunity_type_id}", [
        OpportunityTypeController::class,
        "delete",
    ]);

    Route::post("occupation-area", [OccupationAreaController::class, "store"]);
    Route::put("occupation-area/{occupation_area_id}", [
        OccupationAreaController::class,
        "update",
    ]);
    Route::delete("occupation-area/{occupation_area_id}", [
        OccupationAreaController::class,
        "delete",
    ]);

    Route::delete("profile/curriculum/{id}", [
        ProfileController::class,
        "deleteCurriculum",
    ]);
});

Route::get('curriculum/{filename}', function ($filename) {
    $file = storage_path('app/public/profile/' . $filename);
    if (!file_exists($file)) {
        abort(404);
    }
    return response()->file($file);
});

// Public routes
Route::get("users", [UserController::class, "index"]);
Route::get("home", [HomeController::class, "index"]);
Route::post("/verify-email", [UserController::class, "verifyEmail"]);
Route::get("state", [StateController::class, "index"]);
Route::get("city/{state_id}", [CityController::class, "index"]);
Route::get("opportunity", [OpportunityController::class, "index"]);
Route::get("opportunity/{opportunity_id}", [
    OpportunityController::class,
    "show",
]);
Route::get("opportunity-renew/{opportunity_id}", [
    OpportunityController::class,
    "renew",
]);
Route::get("client/{id}", [ClientController::class, "show"]);

// Command routes
Route::get("opportunity-inactived-command", function () {
    return Illuminate\Support\Facades\Artisan::call(
        "app:opportunity-inactived-command"
    );
});
Route::get("opportunity-expire-few-days-command", function () {
    return Illuminate\Support\Facades\Artisan::call(
        "app:opportunity-expire-few-days-command"
    );
});

// Opportunity Type and Occupation Area
Route::get("opportunity-type", [OpportunityTypeController::class, "index"]);
Route::get("occupation-area", [OccupationAreaController::class, "index"]);

// Email sender route for authenticated users
Route::post("send-opportunity-email/{opportunity_id}", [
    ProfileController::class,
    "sendOpportunityEmail",
])->middleware("auth:api")->where('opportunity_id', '[0-9]+');

// Settings route
Route::get("settings", [SettingController::class, "index"]);

Route::get("integrator-section", [IntegratorSectionController::class, "index"]);

// ✅ Rotas do Banner
Route::apiResource('banners', BannerController::class);

// ✅ Rotas de HomeAssociate e HomeBookRoom
Route::apiResource('home-associates', HomeAssociateController::class);
Route::apiResource('home-book-rooms', HomeBookRoomController::class);
