<?php

namespace App\Filament\Resources\ReportResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Enums\ReportStatus;

class DocumentRelationManager extends RelationManager
{
    protected static string $relationship = 'docAudits';

    public function form(Form $form): Form
    {
        $user = Auth::user();
        $report = $this->getOwnerRecord()->event;
        $checkMemberEvent = $report->users()->where('user_id', $user->id)->exists();
        $isMember = $user->roles()->where('name', 'member')->exists();

        return $form
            ->schema([
                Forms\Components\Textarea::make('persyaratan')
                    ->required()
                    ->maxLength(255),
                // ->disabled($checkMemberEvent),

                Forms\Components\Select::make('status')
                    ->options([
                        ReportStatus::Pending->value => 'Pending',
                        ReportStatus::Approved->value => 'Approved',
                        ReportStatus::Rejected->value => 'Rejected',
                    ])
                    ->default(fn($record) => $record ? $record->status : ReportStatus::Pending->value)
                    ->disabled($isMember || $checkMemberEvent)
                    ->required(),

                Forms\Components\FileUpload::make('file')
                    ->required()
                    ->directory('uploads')
                    ->visibility('public')
                    ->columnSpan(2),
                // ->disabled($checkMemberEvent),

                Forms\Components\Textarea::make('noted')
                    ->maxLength(255)
                    ->columnSpan(2),
                // ->disabled($checkMemberEvent),
            ]);
    }

    public function table(Table $table): Table
    {
        $user = Auth::user();
        $report = $this->getOwnerRecord()->event;
        $checkMemberEvent = $report->users()->where('user_id', $user->id)->exists();
        // dd($checkMemberEvent);
        return $table
            ->recordTitleAttribute('persyaratan')
            ->columns([
                Tables\Columns\TextColumn::make('persyaratan')
                    ->searchable(),

                Tables\Columns\SelectColumn::make('status')
                    ->searchable()
                    ->options([
                        ReportStatus::Pending->value => 'Pending',
                        ReportStatus::Approved->value => 'Approved',
                        ReportStatus::Rejected->value => 'Rejected',
                    ])
                    ->width('1/5')
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
            ->filters([])
            ->headerActions(
                $checkMemberEvent ? [
                    Tables\Actions\CreateAction::make(),
                ] : []
            )
            ->actions(
                $checkMemberEvent ? [
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ] : []
            )
            ->bulkActions(
                $checkMemberEvent ? [
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ] : []
            );
    }
}
