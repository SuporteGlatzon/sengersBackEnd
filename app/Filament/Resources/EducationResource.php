<?php

namespace App\Filament\Resources;

use App\Filament\Components\Form\EducationForm;
use App\Filament\Components\Table\EducationTable;
use App\Filament\Resources\EducationResource\Pages;
use App\Models\Client;
use App\Models\Education;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ClientResource\RelationManagers\AuditsRelationManager;
use Illuminate\Support\Facades\Auth;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;

    protected static ?string $modelLabel = 'Formação acadêmica';

    protected static ?string $pluralModelLabel = 'Formações acadêmica';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && ($user->role_id === 1 || $user->role_id === 3); // Allow roles with id 1 or 3
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
                    ...EducationForm::make()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Client'))
                    ->searchable()
                    ->sortable(),
                ...EducationTable::make()
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
            'index' => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'view' => Pages\ViewEducation::route('/{record}'),
            'edit' => Pages\EditEducation::route('/{record}/edit'),
        ];
    }
}
