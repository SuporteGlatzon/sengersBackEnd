<?php

namespace App\Providers;

use App\Http\Resources\ClientResource;
use App\Http\Resources\OccupationAreaResource;
use App\Http\Resources\OpportunityResource;
use App\Http\Resources\OpportunityTypeResource;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (env("APP_ENV") !== "local") {
            $this->app["request"]->server->set("HTTPS", "on");
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        OccupationAreaResource::withoutWrapping();
        OpportunityTypeResource::withoutWrapping();
        OpportunityResource::withoutWrapping();
        ClientResource::withoutWrapping();
        ProfileResource::withoutWrapping();
    }
}
