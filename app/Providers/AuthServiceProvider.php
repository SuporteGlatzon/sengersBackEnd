<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Client;
use App\Models\Education;
use App\Models\HomeAssociate;
use App\Models\HomeBanner;
use App\Models\HomeBookRoom;
use App\Models\HomeCard;
use App\Models\OccupationArea;
use App\Models\Opportunity;
use App\Models\OpportunityType;
use App\Models\Setting;
use App\Policies\AuditPolicy;
use App\Policies\ClientPolicy;
use App\Policies\EducationPolicy;
use App\Policies\HomeAssociatePolicy;
use App\Policies\HomeBannerPolicy;
use App\Policies\HomeBookRoomPolicy;
use App\Policies\HomeCardPolicy;
use App\Policies\OccupationAreaPolicy;
use App\Policies\OpportunityPolicy;
use App\Policies\OpportunityTypePolicy;
use App\Policies\SettingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Client::class => ClientPolicy::class,
        Education::class => EducationPolicy::class,
        Opportunity::class => OpportunityPolicy::class,
        HomeAssociate::class => HomeAssociatePolicy::class,
        HomeBanner::class => HomeBannerPolicy::class,
        HomeBookRoom::class => HomeBookRoomPolicy::class,
        HomeCard::class => HomeCardPolicy::class,
        OpportunityType::class => OpportunityTypePolicy::class,
        OccupationArea::class => OccupationAreaPolicy::class,
        Setting::class => SettingPolicy::class,
        Activity::class => AuditPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
