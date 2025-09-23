<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OccupationAreaResource\Pages;
use App\Models\OccupationArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ClientResource\RelationManagers\AuditsRelationManager;
use Illuminate\Support\Facades\Auth;

class OccupationAreaResource extends Resource
{
    protected static ?string $model = OccupationArea::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): string
    {
        return __('Opportunity');
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && ($user->role_id === 1); // Allow roles with id 1
    }

    public static function getModelLabel(): string
    {
        return __('Occupation Area');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Occupations Area');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(__('Title'))
                        ->required(),
                    Forms\Components\Toggle::make('status')
                        ->label('Status'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
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
            'index' => Pages\ListOccupationAreas::route('/'),
            'create' => Pages\CreateOccupationArea::route('/create'),
            'edit' => Pages\EditOccupationArea::route('/{record}/edit'),
        ];
    }
}
