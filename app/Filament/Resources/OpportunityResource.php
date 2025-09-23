<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OpportunityResource\Pages;
use App\Filament\Components\Form\OpportunityForm;
use App\Filament\Components\Table\OpportunityTable;
use App\Models\Client;
use App\Models\Opportunity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ClientResource\RelationManagers\AuditsRelationManager;
use Illuminate\Support\Facades\Auth;

class OpportunityResource extends Resource
{
    protected static ?string $model = Opportunity::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && ($user->role_id === 1 || $user->role_id === 3); // Allow roles with id 1 or 3
    }

    public static function getModelLabel(): string
    {
        return __('Opportunity');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Opportunities');
    }

    public static function getNavigationGroup(): string
    {
        return __('Opportunity');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('user_id')
                        ->label(__('Client'))
                        ->options(Client::query()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    ...OpportunityForm::make()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label(__('Client'))
                    ->searchable()
                    ->sortable(),
                ...OpportunityTable::make()
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
            \App\Filament\Resources\OpportunityResource\RelationManagers\CandidatesRelationManager::class,
            \App\Filament\Resources\AuditResource\RelationManagers\AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOpportunities::route('/'),
            'create' => Pages\CreateOpportunity::route('/create'),
            'view' => Pages\ViewOpportunity::route('/{record}'),
            'edit' => Pages\EditOpportunity::route('/{record}/edit'),
        ];
    }
}
