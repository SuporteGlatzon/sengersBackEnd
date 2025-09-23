<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeAssociateResource\Pages;
use App\Models\HomeAssociate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ClientResource\RelationManagers\AuditsRelationManager;

class HomeAssociateResource extends Resource
{
    protected static ?string $model = HomeAssociate::class;

    protected static ?string $navigationIcon = 'heroicon-m-rectangle-group';

    protected static ?string $navigationGroup = 'Home';

    public static function getModelLabel(): string
    {
        return __('Home Associate');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Home Associate');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->translateLabel()
                    ->required(),

                Forms\Components\TextInput::make('subtitle')
                    ->translateLabel(),

                Forms\Components\FileUpload::make('image')
                    ->translateLabel()
                    ->imageEditor(),

                Forms\Components\RichEditor::make('description')
                    ->translateLabel()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('orange_text')
                    ->translateLabel(),

                Forms\Components\TextInput::make('title_right')
                    ->translateLabel(),

                Forms\Components\TextInput::make('button_link')
                    ->translateLabel()
                    ->url(),

                Forms\Components\TextInput::make('button_text')
                    ->translateLabel(),


                Forms\Components\TagsInput::make('advantages')
                    ->translateLabel()
                    ->reorderable()
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('status')
                    ->label('Status'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->translateLabel(),
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
            'index' => Pages\ListHomeAssociates::route('/'),
            'create' => Pages\CreateHomeAssociate::route('/create'),
            'edit' => Pages\EditHomeAssociate::route('/{record}/edit'),
        ];
    }
}
