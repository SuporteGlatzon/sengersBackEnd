<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Components\Form\EducationForm;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EducationsRelationManager extends RelationManager
{
    protected static string $relationship = 'educations';

    protected static ?string $title = 'Formação acadêmica';

    protected static ?string $modelLabel = 'Formação acadêmica';

    protected static ?string $pluralModelLabel = 'Formações acadêmica';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ...EducationForm::make()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('course')
            ->columns([
                Tables\Columns\TextColumn::make('institution')
                    ->label(__('Institution'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course')
                    ->label(__('Course'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_situation')
                    ->label(__('Current situation'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conclusion_at')
                    ->label(__('Conclusion at'))
                    ->searchable()
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
            ]);
    }
}
