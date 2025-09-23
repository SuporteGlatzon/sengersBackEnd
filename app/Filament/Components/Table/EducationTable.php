<?php

namespace App\Filament\Components\Table;

use Filament\Tables;

class EducationTable
{
    public static function make()
    {
        return [
            Tables\Columns\TextColumn::make('institution')
                ->label(__('Institution'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('course')
                ->label(__('Course'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('current_situation')
                ->label(__('Current situation'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('conclusion_at')
                ->label(__('Conclusion at'))
                ->searchable()
                ->sortable(),
        ];
    }
}
