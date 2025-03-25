<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        Forms\Components\ColorPicker::make('colorId')
                            ->required()
                            ->columnSpan(2),

                        Forms\Components\Select::make('users') // Sesuai dengan relasi event_user
                            ->relationship('users', 'name')
                            ->multiple()
                            ->label('Access')
                            ->disabled()
                            ->default(fn() => self::getDefaultAccess()),
                        Forms\Components\Select::make('auditor_ids') // Sesuai dengan database
                            ->relationship('auditor', 'name')
                            ->multiple()
                            ->live()
                            ->afterStateUpdated(fn($state, callable $set) => self::updateAccessField($state, $set)),
                        FileUpload::make('file')
                            ->label('Documentation')
                            ->columnSpan(2),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Audit Schedule (Sync with Calendar)')
                            ->schema([
                                Forms\Components\DateTimePicker::make('startDateTime')
                                    ->label('Start')
                                    ->required(),
                                Forms\Components\DateTimePicker::make('endDateTime')
                                    ->label('End')
                                    ->required(),
                            ]),
                        Forms\Components\Section::make("Audit Day's")
                            ->schema([
                                Forms\Components\DateTimePicker::make('startDateAudit')
                                    ->label('Start')
                                    ->required()
                                    ->default(fn($get) => $get('startDateTime'))
                                    ->minDate(fn($get) => $get('startDateTime'))
                                    ->maxDate(fn($get) => $get('endDateTime')),
                                Forms\Components\DateTimePicker::make('endDateAudit')
                                    ->label('End')
                                    ->required()
                                    ->default(fn($get) => $get('endDateTime'))
                                    ->minDate(fn($get) => $get('startDateTime'))
                                    ->maxDate(fn($get) => $get('endDateTime'))

                            ]),
                    ])
                    ->columnSpan(['lg' => 1])
            ])
            ->columns(3);
    }

    private static function updateAccessField($auditorIds, callable $set)
    {
        $user = Auth::user();
        $auditorUsers = is_array($auditorIds) ? User::whereIn('id', $auditorIds)->pluck('id')->toArray() : [];

        $roleUsers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Teknis', 'Admin']);
        })->pluck('id')->toArray();

        $accessUsers = array_unique(array_merge($auditorUsers, $roleUsers, [$user->id]));

        $set('users', $accessUsers);
    }

    protected static function getDefaultAccess(): array
    {
        $user = Auth::user();
        $roleUsers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Teknis', 'Admin']);
        })->pluck('id')->toArray();

        $eventId = request()->route('record');
        $auditorUsers = $eventId ? Event::find($eventId)?->auditor()->pluck('users.id')->toArray() ?? [] : [];

        $creatorUser = $eventId ? Event::find($eventId)?->created_by : $user->id;

        return array_unique(array_merge($roleUsers, $auditorUsers, [$user->id, $creatorUser]));
    }

    // berguna untuk mengatur akses user yang dapat mengakses data
    // yang dihasilkan oleh resource ini
    public static function mutateRelationshipDataBeforeCreate(array $data): array
    {
        $data['users'] = self::getDefaultAccess();
        return $data;
    }

    public static function mutateRelationshipDataBeforeSave(array $data): array
    {
        $data['users'] = self::getDefaultAccess();
        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('colorId')->searchable(),
                Tables\Columns\TextColumn::make('startDateTime')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('endDateTime')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            });
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
