<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntegratorSectionResource\Pages;
use App\Models\IntegratorSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class IntegratorSectionResource extends Resource
{
    protected static ?string $model = IntegratorSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && ($user->role_id === 1 || $user->role_id === 2); // Allow roles with id 1 or 2
    }

    public static function getModelLabel(): string
    {
        return __('Integrator Sections');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('text')
                ->required()
                ->label('Text'),
            Forms\Components\TextInput::make('button_text')
                ->required()
                ->label('Button Text'),
            Forms\Components\TextInput::make('button_link')
                ->required()
                ->url()
                ->label('Button Link'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('text')
                    ->translateLabel()
                    ->label('Text')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('button_text')
                    ->translateLabel()
                    ->label('Button Text')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('button_link')
                    ->translateLabel()
                    ->label('Button Link')
                    ->sortable()
                    ->url(fn($record) => $record ? $record->button_link : '#', true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIntegratorSections::route('/'),
            'create' => Pages\CreateIntegratorSection::route('/create'),
            'edit' => Pages\EditIntegratorSection::route('/{record}/edit'),
        ];
    }
}
