<?php

return [
    'resources' => [
        'label' => 'Log de Atividade',
        'plural_label' => 'Logs de Atividades',
        'navigation_group' => 'Configuração',
        'navigation_icon' => 'heroicon-o-shield-check',
        'navigation_sort' => null,
        'navigation_count_badge' => false,
        'resource' => \App\Filament\Resources\CustomActivitylogResource::class,
    ],
    'datetime_format' => 'd/m/Y H:i:s',
];
