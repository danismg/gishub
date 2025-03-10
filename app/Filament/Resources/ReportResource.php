<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers\DocumentRelationManager;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Report Audit';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'sort_name')
                    ->required(),

                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('laboratorium')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DateTimePicker::make('tanggal_audit')
                    ->required(),
                Forms\Components\DateTimePicker::make('tanggal_terbit')
                    ->required(),

                Forms\Components\TextInput::make('auditor')
                    ->required()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->limit(10) // Batasi teks hingga 10 karakter
                    ->tooltip(fn($state) => $state) // Tampilkan teks lengkap saat hover
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->limit(10) // Batasi teks hingga 10 karakter
                    ->tooltip(fn($state) => $state) // Tampilkan teks lengkap saat hover
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('laboratorium')
                    ->limit(10) // Batasi teks hingga 10 karakter
                    ->tooltip(fn($state) => $state) // Tampilkan teks lengkap saat hover
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('auditor')
                    ->limit(10) // Batasi teks hingga 10 karakter
                    ->tooltip(fn($state) => $state) // Tampilkan teks lengkap saat hover
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service.sort_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_audit')
                    // ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_terbit')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    // ->dateTime()
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\EditAction::make(),
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
