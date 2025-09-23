<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntegratorSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\IntegratorSection::create([
            'text' => 'Você está cadastrando uma oportunidade de estágio. Conheça o nosso agente integrador para facilitar esse trabalho.',
            'button_text' => 'Conheça agora',
            'button_link' => 'https://example.com',
        ]);
    }
}
