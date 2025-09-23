<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('regions')->count()) {
            return;
        }

        DB::table('regions')->insert(array(
            0 =>
            array(
                'id' => '1',
                'title' => 'Norte',
                'slug' => 'norte'
            ),
            1 =>
            array(
                'id' => '2',
                'title' => 'Nordeste',
                'slug' => 'nordeste'
            ),
            2 =>
            array(
                'id' => '3',
                'title' => 'Centro-Oeste',
                'slug' => 'centro-oeste'
            ),
            3 =>
            array(
                'id' => '4',
                'title' => 'Sudeste',
                'slug' => 'sudeste'
            ),
            4 =>
            array(
                'id' => '5',
                'title' => 'Sul',
                'slug' => 'sul'
            ),
        ));
    }
}
