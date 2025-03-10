<?php

namespace App\Filament\Resources\ReportResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentRelationManager extends RelationManager
{
    protected static string $relationship = 'docAudits';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // persyaratan, file, status [enum panding, approved, rejected]
                Forms\Components\Textarea::make('persyaratan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('file')
                    ->required()
                    ->columnSpan(2),

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
                    ]),
                Tables\Columns\TextColumn::make('file')
                    ->label('Download')
                    ->formatStateUsing(fn($state) => $state ? 'Download' : 'No File')
                    ->url(fn($record) => $record->file ? asset('storage/' . $record->file) : '#', true)
                    ->icon('heroicon-o-arrow-down-tray') // Ganti dengan ikon yang tersedia
                    ->openUrlInNewTab(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
