<?php

namespace App\Filament\Resources;

use App\Enums\ReportStatus;
use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers\DocumentRelationManager;
use App\Models\Report;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Report Audit';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Report Summary')
                        ->schema([
                            Select::make('event_id')
                                ->label('Event')
                                ->searchable()
                                ->options(
                                    Event::whereHas('users', fn($query) => $query->where('user_id', Auth::id()))
                                        ->pluck('name', 'id')
                                )
                                ->reactive()
                                ->required()
                                ->afterStateUpdated(fn($state, callable $set) => self::updateEventDetails($state, $set)),

                            Select::make('service_id')
                                ->relationship('service', 'sort_name')
                                ->required(),
                        ])->columns(2),

                    Forms\Components\Section::make('Audited Company Details')
                        ->schema([
                            Forms\Components\TextInput::make('company_name')
                                ->label('Company Name')
                                ->required()
                                ->columnSpan(2)
                                ->maxLength(255),

                            Forms\Components\TextInput::make('location')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('laboratorium')
                                ->required()
                                ->maxLength(255),
                        ])->columns(2),
                ])->columns(2)->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()
                ->schema([

                    Group::make()->schema([
                        Hidden::make('status')
                            ->label('Status')
                            ->disabled() // Status otomatis diperbarui, tidak bisa diubah manual
                            ->dehydrated(false) // Jangan kirim data status saat submit form
                            ->default(ReportStatus::New->value),

                    ]),


                    Forms\Components\Section::make('Auditor')
                        ->schema([
                            Forms\Components\Placeholder::make('auditor')
                                ->label(' ')
                                ->content(fn($get) => self::getAuditorNames($get('event_id')))
                                ->reactive(),
                        ]),


                    Forms\Components\Section::make('Audit Schedule')
                        ->schema([
                            Forms\Components\DateTimePicker::make('tanggal_audit')
                                ->label('Start')
                                ->disabled()
                                ->dehydrated()
                                ->reactive()
                                ->default(fn($get) => Event::find($get('event_id'))?->start_date_audit ?? now()),

                            Forms\Components\DateTimePicker::make('tanggal_terbit')
                                ->label('End')
                                ->disabled()
                                ->dehydrated()
                                ->reactive()
                                ->default(fn($get) => Event::find($get('event_id'))?->end_date_audit ?? now()->addDays(1)),
                        ]),
                ])->columnSpan(['lg' => 1])
        ])->columns(3);
    }

    private static function updateEventDetails($state, callable $set): void
    {
        $event = Event::find($state);
        $set('company_name', $event?->name ?? '');
        $set('tanggal_audit', $event?->startDateAudit ?? null);
        $set('tanggal_terbit', $event?->endDateAudit ?? null);
    }

    private static function getAuditorNames($eventId): string
    {
        return $eventId ? implode(', ', Event::find($eventId)?->auditor()->pluck('name')->toArray() ?? []) : 'Tidak ada auditor';
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('company_name')->limit(10)->tooltip(fn($state) => $state)->searchable()->sortable(),
            TextColumn::make('location')->limit(10)->tooltip(fn($state) => $state)->searchable()->sortable(),
            TextColumn::make('laboratorium')->limit(10)->tooltip(fn($state) => $state)->searchable()->sortable(),
            TextColumn::make('service.sort_name')->numeric()->sortable(),

            BadgeColumn::make('status')
                ->formatStateUsing(fn($state) => ReportStatus::tryFrom($state)?->getLabel() ?? 'Unknown')
                ->color(fn($state) => ReportStatus::tryFrom($state)?->getColor() ?? 'gray')
                ->icon(fn($state) => ReportStatus::tryFrom($state)?->getIcon() ?? 'heroicon-m-question-mark-circle')
                ->sortable(),
            TextColumn::make('tanggal_audit')
                ->label("Audit Day's")
                ->formatStateUsing(fn($record) => $record->tanggal_audit && $record->tanggal_terbit
                    ? (\Carbon\Carbon::parse($record->tanggal_audit)->format('F') === \Carbon\Carbon::parse($record->tanggal_terbit)->format('F')
                        ? \Carbon\Carbon::parse($record->tanggal_audit)->format('d') . ' - ' . \Carbon\Carbon::parse($record->tanggal_terbit)->format('d F Y')
                        : \Carbon\Carbon::parse($record->tanggal_audit)->format('d F') . ' - ' . \Carbon\Carbon::parse($record->tanggal_terbit)->format('d F Y'))
                    : 'N/A')
                ->sortable(),
            // TextColumn::make('tanggal_audit')->label('Start Audit Days')->sortable()
            // TextColumn::make('tanggal_terbit')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn() => !Auth::user()->roles()->where('name', 'member')->exists()),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        ReportStatus::Processing->value => 'Processing',
                        ReportStatus::Approved->value => 'Approved',
                        ReportStatus::Rejected->value => 'Rejected',
                    ]),
                SelectFilter::make('service_id')
                    ->relationship('service', 'sort_name'),
            ])->bulkActions([
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
