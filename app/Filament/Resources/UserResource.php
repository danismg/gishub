<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\EditRecord;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))->dehydrated(fn(?string $state): bool => filled($state))
                        ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord),
                    TextInput::make('email')
                        ->email()
                        ->required(),
                    Select::make('roles')
                        ->relationship('roles', 'name'),


                    FileUpload::make('avatar_url')
                        ->image()
                        ->disk('public')
                        ->rules('mimes:jpeg,png')
                        ->columnSpan(2)
                        ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord || $livewire instanceof EditRecord),
                ])
                ->columns(2)
                ->columnSpan(['lg' => fn(?User $record) => $record === null ? 2 : 2]),
            Forms\Components\Section::make()
                ->schema([
                    TextInput::make('link_facebook')->label('Link Facebook'),
                    TextInput::make('link_instagram')->label('Link Instagram'),
                    TextInput::make('link_twitter')->label('Link Twitter'),
                ])
                // label
                ->label('Social Media')
                ->columnSpan(['lg' => 1]),


        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->sortable()
                ->searchable(),

            TextColumn::make('email')
                ->sortable()
                ->searchable(),

            TextColumn::make('roles.name'),

            ImageColumn::make('avatar_url')
                ->disk('public')
                ->circular(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
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
