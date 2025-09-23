<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeCardResource\Pages;
use App\Models\HomeCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ClientResource\RelationManagers\AuditsRelationManager;

class HomeCardResource extends Resource
{
    protected static ?string $model = HomeCard::class;

    protected static ?string $navigationIcon = 'heroicon-m-square-3-stack-3d';

    protected static ?string $navigationGroup = 'Home';

    public static function getModelLabel(): string
    {
        return __('Home Card');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Home Cards');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->translateLabel()
                    ->required(),

                Forms\Components\TextInput::make('call')
                    ->translateLabel(),

                Forms\Components\TextInput::make('subtitle')
                    ->translateLabel(),

                Forms\Components\TextInput::make('button_text')
                    ->translateLabel(),

                Forms\Components\TextInput::make('link')
                    ->translateLabel()
                    ->url(),

                Forms\Components\Toggle::make('status')
                    ->label('Status')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()->visible(request()->user()->canFullPermission()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\AuditResource\RelationManagers\AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeCards::route('/'),
            'create' => Pages\CreateHomeCard::route('/create'),
            'edit' => Pages\EditHomeCard::route('/{record}/edit'),
        ];
    }
}
