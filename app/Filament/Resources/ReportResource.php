<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers\DocumentRelationManager;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Components\KeyValueEntry;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Report Audit';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        // $user = Auth::user();
        // $isMember = $user->roles()->where('name', 'member')->exists();

        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make('Report Auditor')
                            ->schema([
                                Forms\Components\TextInput::make('company_name')
                                    ->required()
                                    ->maxLength(255),
                                // ->disabled($isMember),

                                Forms\Components\Select::make('service_id')
                                    ->relationship('service', 'sort_name')
                                    ->required(),
                                // ->disabled($isMember),

                                Forms\Components\TextInput::make('location')
                                    ->required()
                                    ->maxLength(255),
                                // ->disabled($isMember),

                                Forms\Components\TextInput::make('laboratorium')
                                    ->required()
                                    ->maxLength(255),
                                // ->disabled($isMember),
                            ])->columns(2),
                        Forms\Components\Section::make('Event')
                            ->schema([
                                Forms\Components\Select::make('event_id')
                                    ->label('Event')
                                    ->options(
                                        \App\Models\Event::whereHas('users', function ($query) {
                                            $query->where('user_id', Auth::id());
                                        })->pluck('name', 'id')
                                    )
                                    // ->live() // Menjadikan event_id reactive
                                    ->reactive() // Supaya berubah otomatis
                                    ->required(),
                                // ->disabled($isMember),
                                Forms\Components\Placeholder::make('Auditor')
                                    ->label('Audit')
                                    ->content(function ($get) {
                                        $event = \App\Models\Event::find($get('event_id'));
                                        return $event ? implode(', ', $event->users()->pluck('users.name')->toArray()) : 'Tidak ada auditor';
                                    }),
                            ])->columns(2),
                    ])

                    ->columns(2)
                    ->columnSpan(['lg' => fn(?Report $record) => $record === null ? 2 : 2]),

                Forms\Components\Section::make('Timeline')
                    ->schema([
                        Forms\Components\DateTimePicker::make('tanggal_audit')
                            ->required(),
                        // ->disabled($isMember),
                        Forms\Components\DateTimePicker::make('tanggal_terbit')
                            ->required(),
                        // ->disabled($isMember),
                    ])
                    ->columnSpan(['lg' => 1])

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->limit(10)
                    ->tooltip(fn($state) => $state)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->limit(10)
                    ->tooltip(fn($state) => $state)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('laboratorium')
                    ->limit(10)
                    ->tooltip(fn($state) => $state)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service.sort_name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('event.users.name')
                //     ->label('Auditor')
                //     ->limit(10)
                //     ->tooltip(fn($state) => $state)
                //     ->searchable()
                //     ->sortable(),


                Tables\Columns\TextColumn::make('tanggal_audit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_terbit')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn() => !Auth::user()->roles()->where('name', 'member')->exists()),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DocumentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
