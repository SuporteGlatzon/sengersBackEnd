<?php

namespace App\Filament\Components\Table;

use Filament\Tables;

class OpportunityTable
{
    public static function make()
    {
        return  [
            Tables\Columns\TextColumn::make('company')
                ->label(__('Company'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('cnpj')
                ->translateLabel()
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('title')
                ->label(__('Title'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('salary')
                ->label(__('Salary'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('date')
                ->label(__('Date'))
                ->searchable()
                ->sortable(),
            Tables\Columns\IconColumn::make('status')
                ->sortable(),
            Tables\Columns\TextColumn::make('situation')
                ->label(__('Situation'))
                ->sortable(),
        ];
    }
}
