<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{

    private $items = ['superadmin', 'admin', 'client'];

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->items as $item) {
            Role::firstOrCreate(['name' => $item]);
        }
    }
}
