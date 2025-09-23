<?php

namespace App\Filament\Resources\OpportunityResource\RelationManagers;

use App\Filament\Components\Form\OpportunityForm;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CandidatesRelationManager extends RelationManager
{
    protected static string $relationship = 'candidates';

    protected static ?string $title = 'Candidato';

    protected static ?string $modelLabel = 'Candidatos';

    protected static ?string $pluralModelLabel = 'Candidato';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ...OpportunityForm::make()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('E-mail'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordSelect(
                        fn (Select $select) => $select->options(Client::whereDoesntHave('candidates', function ($query) {
                            $query->where('opportunity_id', $this->ownerRecord->id);
                        })->whereNot('id', $this->ownerRecord->user_id)->pluck('name', 'id')),
                    )
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
