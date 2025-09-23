<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    public function form(Form $form): Form
    {
        $showRichEditor = in_array($this->record->key, ['privacy_policy', 'terms_of_use', 'terms_of_opportunity']);

        return $form
            ->schema([
                TextInput::make('key')
                    ->label(__('Key'))
                    ->required()
                    ->disabled()
                    ->unique(ignoreRecord: true),
                TextInput::make('description')
                    ->label(__('Description'))
                    ->required(),
                TextInput::make('value')
                    ->label(__('Value'))
                    ->required()
                    ->visible(!$showRichEditor)
                    ->columnSpanFull(),
                RichEditor::make('value')
                    ->label(__('Value'))
                    ->required()
                    ->visible($showRichEditor)
                    ->columnSpanFull(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
