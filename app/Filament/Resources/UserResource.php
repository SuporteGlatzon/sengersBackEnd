<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationGroup(): string
    {
        return __('User Management');
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->role_id === 1; // Assuming role_id 1 is for "Super Admin"
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('Name')),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label(__('Email')),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label(__('Password'))
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->required(),

                Forms\Components\Select::make('role_id')
                    ->label(__('Role'))
                    ->options([
                        1 => __('Super Admin'),
                        2 => __('Comunication'), // Admin
                        3 => __('Moderator'), // User
                    ])
                    ->required()
                    ->default(3),

                Forms\Components\TextInput::make('phone')
                    ->label(__('Phone Number')),

                Forms\Components\TextInput::make('address')
                    ->label(__('Address')),

                Forms\Components\TextInput::make('link_site')
                    ->label(__('Website')),

                Forms\Components\TextInput::make('link_instagram')
                    ->label('Instagram'),

                Forms\Components\TextInput::make('link_twitter')
                    ->label('Twitter'),

                Forms\Components\TextInput::make('link_linkedin')
                    ->label('LinkedIn'),

                Forms\Components\FileUpload::make('avatar')
                    ->label(__('Avatar Image')),

                Forms\Components\Toggle::make('senge_associate')
                    ->label(__('Senge Associate')),

                Forms\Components\Toggle::make('active')
                    ->label(__('Active'))
                    ->default(true)
                    ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->query(User::where('user_type', 'user'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('Name')),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label(__('Email')),

                Tables\Columns\TextColumn::make('role_id')
                    ->label(__('Role'))
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => __('Super Admin'),
                        2 => __('Comunication'), // Admin
                        3 => __('Moderator'), // User
                        default => __('Unknown'),
                    }),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone Number')),

                Tables\Columns\TextColumn::make('address')
                    ->label(__('Address')),

                Tables\Columns\BooleanColumn::make('senge_associate')
                    ->label(__('Senge Associate')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()->visible(request()->user()->canFullPermission()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
