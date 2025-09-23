<?php

namespace App\Console\Commands;

use App\Models\Opportunity;
use Illuminate\Console\Command;

class OpportunityInactivedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:opportunity-inactived-command';

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
        Opportunity::where('expire_at', '<=', now())->get()->each(function ($opportunity) {
            $opportunity->situation = Opportunity::SITUATION_EXPIRED;
            $opportunity->save();
        });
    }
}
