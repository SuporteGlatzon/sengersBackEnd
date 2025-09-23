<?php

namespace App\Filament\Components\Form;

use App\Enums\OpportunitySituation;
use App\Models\City;
use App\Models\OccupationArea;
use App\Models\Opportunity;
use App\Models\OpportunityType;
use App\Models\State;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Get;
use Illuminate\Support\Collection;

class OpportunityForm
{
    public static function make()
    {
        return [
            Forms\Components\Grid::make()->schema([
                Forms\Components\Select::make('opportunity_type_id')
                    ->label(__('Type Opportunity'))
                    ->options(OpportunityType::query()->pluck('title', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('occupation_area_id')
                    ->label(__('Occupation Area'))
                    ->options(OccupationArea::query()->pluck('title', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('company')
                    ->label(__('Company')),
                Forms\Components\TextInput::make('cnpj')
                    ->rules(['cnpj'])
                    ->mask('99.999.999/9999-99'),
                Forms\Components\TextInput::make('title')
                    ->label(__('Title'))
                    ->required(),
                Forms\Components\Select::make('state_id')
                    ->label(__('State'))
                    ->options(State::query()->pluck('title', 'id'))
                    ->searchable()
                    ->live(),
                Forms\Components\Select::make('city_id')
                    ->label(__('City'))
                    ->options(fn (Get $get): Collection => City::query()
                        ->where('state_id', $get('state_id'))
                        ->pluck('title', 'id'))
                    ->searchable(),
                Forms\Components\DatePicker::make('date')
                    ->label(__('Date')),
                Forms\Components\TextInput::make('salary')
                    ->label(__('Salary')),
                Forms\Components\RichEditor::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('full_description')
                    ->label(__('Full description'))
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('status')
                    ->label('Status')
                    ->columnSpanFull(),
                Forms\Components\ToggleButtons::make('situation')
                    ->label(__('Situation'))
                    ->inline()
                    ->options(OpportunitySituation::class)
                    ->disableOptionWhen(fn ($value) => $value === Opportunity::SITUATION_PENDING)
                    ->live(),
                Forms\Components\Textarea::make('situation_description')
                    ->label(__('No approved description'))
                    ->visible(function (Get $get) {
                        return $get('situation') == Opportunity::SITUATION_NO_APPROVED;
                    })->columnSpanFull(),

                Forms\Components\Select::make('approved_by')
                    ->relationship(titleAttribute: 'name')
                    ->searchable()
                    ->translateLabel()
                    ->visible(function (Get $get) {
                        return $get('situation') == Opportunity::SITUATION_APPROVED;
                    })
                    ->disabled()
                    ->columnSpanFull(),
            ])
        ];
    }
}
