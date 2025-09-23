<?php

namespace App\Filament\Components\Form;

use App\Enums\CurrentSituation;
use Filament\Forms;

class EducationForm
{
    public static function make()
    {
        return [
            Forms\Components\Grid::make()->schema([
                Forms\Components\TextInput::make('institution')
                    ->label(__('Institution'))
                    ->required()
                    ->columns(6),
                Forms\Components\TextInput::make('course')
                    ->label(__('Course'))
                    ->required()
                    ->columns(6),
                Forms\Components\DatePicker::make('conclusion_at')
                    ->label(__('Current situation'))
                    ->columns(6),
                Forms\Components\ToggleButtons::make('current_situation')
                    ->label(__('Current situation'))
                    ->inline()
                    ->options(CurrentSituation::class),
                Forms\Components\RichEditor::make('observation')
                    ->label(__('Observation'))
                    ->columnSpanFull(),
            ])
        ];
    }
}
