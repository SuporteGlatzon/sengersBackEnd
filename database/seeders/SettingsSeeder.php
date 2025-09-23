<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    private $items = [
        [
            'key' => 'days_expire_opportunity',
            'value' => '30',
            'description' => 'Days to expire opportunities'
        ],
        [
            'key' => 'send_mail_days_before_opportunity_expire',
            'value' => '5',
            'description' => 'Send mail days before the opportunity expires'
        ],
        [
            'key' => 'terms_of_use',
            'value' => '',
            'description' => 'Terms of use'
        ],
        [
            'key' => 'privacy_policy',
            'value' => '',
            'description' => 'Privacy Policy'
        ],
        [
            'key' => 'address',
            'value' => '',
            'description' => 'Address'
        ],
        [
            'key' => 'email',
            'value' => '',
            'description' => 'E-mail'
        ],
        [
            'key' => 'phone',
            'value' => '',
            'description' => 'phone'
        ],
        [
            'key' => 'terms_of_opportunity',
            'value' => '',
            'description' => 'Terms of opportunity'
        ]
    ];

    /**
     * Auto generated seed file
     *
     * @return void
     */

    public function run()
    {
        foreach ($this->items as $item) {
            Setting::firstOrCreate(['key' => $item['key']], $item);
        }
    }
}
