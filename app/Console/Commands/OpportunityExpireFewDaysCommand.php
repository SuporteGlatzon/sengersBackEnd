<?php

namespace App\Console\Commands;

use App\Models\Opportunity;
use App\Models\Setting;
use App\Notifications\OpportunityExpireFewDaysNotification;
use Illuminate\Console\Command;

class OpportunityExpireFewDaysCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:opportunity-expire-few-days-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days_expire_opportunity = Setting::where('key', 'send_mail_days_before_opportunity_expire')->first();

        $add_days = $days_expire_opportunity ? $days_expire_opportunity->value : 5;

        $date = now()->addDays($add_days);

        Opportunity::where('expire_at', '<=', $date)->whereNull('expire_notification_at')->get()->each(function ($opportunity) {
            $opportunity->expire_notification_at = now();
            $opportunity->save();

            $opportunity->client->notify(new OpportunityExpireFewDaysNotification($opportunity));
        });
    }
}
