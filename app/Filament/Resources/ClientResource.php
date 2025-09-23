<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\City;
use App\Models\Client;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Support\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ClientResource\RelationManagers\AuditsRelationManager;
use Illuminate\Support\Facades\Auth;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && ($user->role_id === 1 || $user->role_id === 3); // Allow roles with id 1 or 3
    }

    public static function getModelLabel(): string
    {
        return __('Clients');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('infos'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required(),

                        Forms\Components\TextInput::make('cpf')
                            ->rules(['cpf'])
                            ->mask('999.999.999-99'),

                        Forms\Components\TextInput::make('code_crea')
                            ->translateLabel(),

                        Forms\Components\TextInput::make('email')
                            ->label('E-mail')
                            ->required()
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->disabled(!request()->user()->canFullPermission()),

                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->label(__('Description')),
                        Forms\Components\RichEditor::make('full_description')
                            ->label(__('Full description')),
                        Forms\Components\FileUpload::make('banner_profile')
                            ->label('Banner perfil')
                            ->imageEditor()
                            ->columnSpan(['lg' => 2]),
                        Forms\Components\Toggle::make('senge_associate')
                            ->label('Associado Senge')
                            ->default(false),
                        Forms\Components\Toggle::make('active')
                            ->label(__('Active'))
                            ->default(true)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('curriculum')
                            ->label('Curriculo')
                            ->downloadable()
                            ->columnSpan(['lg' => 2]),

                    ])->columns(2)
                    ->columnSpan(['lg' => fn(?Client $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('Data de criação'))
                            ->content(fn(Client $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Última modificação')
                            ->content(fn(Client $record): ?string => $record->updated_at?->diffForHumans()),

                        Forms\Components\ViewField::make('avatar')
                            ->view('components.image-preview'),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn(?Client $record) => $record === null),

                Forms\Components\Section::make('Endereço')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Select::make('state_id')
                                    ->label(__('State'))
                                    ->options(State::query()->pluck('title', 'id'))
                                    ->searchable()
                                    ->live(),
                                Forms\Components\Select::make('city_id')
                                    ->label(__('City'))
                                    ->options(fn(Get $get): Collection => City::query()
                                        ->where('state_id', $get('state_id'))
                                        ->pluck('title', 'id'))
                                    ->searchable(),
                                Forms\Components\Textarea::make('address')->label('Endereço'),
                                Forms\Components\Textarea::make('complement')->label('Complemento'),
                            ]),
                    ]),
                Forms\Components\Section::make('Redes Sociais')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('link_site')
                                    ->suffixIcon('heroicon-m-globe-alt'),
                                Forms\Components\TextInput::make('link_instagram')
                                    ->suffixIcon('heroicon-m-globe-alt'),
                                Forms\Components\TextInput::make('link_twitter')
                                    ->suffixIcon('heroicon-m-globe-alt'),
                                Forms\Components\TextInput::make('link_linkedin')
                                    ->suffixIcon('heroicon-m-globe-alt'),
                            ]),
                    ]),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Client::where('user_type', 'client'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular(),
                Tables\Columns\IconColumn::make('senge_associate')
                    ->label('Associado Senge')
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
            \App\Filament\Resources\ClientResource\RelationManagers\EducationsRelationManager::class,
            \App\Filament\Resources\ClientResource\RelationManagers\OpportunitiesRelationManager::class,
            \App\Filament\Resources\AuditResource\RelationManagers\AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
