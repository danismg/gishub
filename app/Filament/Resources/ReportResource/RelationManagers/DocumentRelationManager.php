<?php

namespace App\Filament\Resources\ReportResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DocumentRelationManager extends RelationManager
{
    protected static string $relationship = 'docAudits';

    public function form(Form $form): Form
    {
        $user = Auth::user();
        $isMember = $user->roles()->where('name', 'member')->exists();

        return $form
            ->schema([
                Forms\Components\Textarea::make('persyaratan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->disabled($isMember)
                    ->required(),
                Forms\Components\FileUpload::make('file')
                    ->required()
                    ->columnSpan(2),
                // noted
                Forms\Components\Textarea::make('noted')
                    ->required()
                    ->disabled($isMember)
                    ->maxLength(255),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('persyaratan')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('status')
                    ->searchable()
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->disabled(fn() => Auth::user()->roles()->where('name', 'member')->exists()),
                Tables\Columns\TextColumn::make('noted')
                    ->limit(10)
                    ->default('Null')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file')
                    ->label('Download')
                    ->formatStateUsing(fn($state) => $state ? 'Download' : 'No File')
                    ->url(fn($record) => $record->file ? asset('storage/' . $record->file) : '#', true)
                    ->icon('heroicon-o-arrow-down-tray')
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
