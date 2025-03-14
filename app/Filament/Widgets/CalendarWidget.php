<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EventResource;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Event;
use Carbon\Carbon;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Actions\DeleteAction;
use Saade\FilamentFullCalendar\Actions\EditAction;
use Saade\FilamentFullCalendar\Actions\ViewAction;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Event::class;

    public function fetchEvents(array $fetchInfo): array
    {
        $googleEvents = GoogleCalendarEvent::get();
        // dd($googleEvents);
        $user = auth()->user();

        if ($user->hasRole('Admin') || $user->hasRole('Teknis')) {
            foreach ($googleEvents as $googleEvent) {
                $existingEvent = Event::where('google_calendar_event_id', $googleEvent->id)->first();;
                if ($existingEvent) {
                    $existingEvent->update([
                        'name' => $googleEvent->summary,
                        'colorId' => '#' . substr(md5($googleEvent->summary), 0, 6),
                        'startDateTime' => Carbon::parse($googleEvent->start->dateTime ?? $googleEvent->start->date)->format('Y-m-d H:i:s'),
                        'endDateTime' => Carbon::parse($googleEvent->end->dateTime ?? $googleEvent->end->date)->format('Y-m-d H:i:s'),
                    ]);
                    $teknisUsers = \App\Models\User::whereHas('roles', function ($query) {
                        $query->where('name', 'teknis');
                    })->pluck('id')->toArray();

                    if (!empty($teknisUsers)) {
                        $existingEvent->users()->attach($teknisUsers);
                    }
                } else {
                    $event = Event::create([
                        'google_calendar_event_id' => $googleEvent->id,
                        'name' => $googleEvent->summary,
                        'colorId' => '#' . substr(md5($googleEvent->summary), 0, 6),
                        'startDateTime' => Carbon::parse($googleEvent->start->dateTime ?? $googleEvent->start->date)->format('Y-m-d H:i:s'),
                        'endDateTime' => Carbon::parse($googleEvent->end->dateTime ?? $googleEvent->end->date)->format('Y-m-d H:i:s'),
                    ]);

                    $teknisUsers = \App\Models\User::whereHas('roles', function ($query) {
                        $query->where('name', 'teknis');
                    })->pluck('id')->toArray();

                    if (!empty($teknisUsers)) {
                        $event->users()->attach($teknisUsers);
                    }
                }
            }
        }

        // jika user adlaah admin ambil semua event database
        if ($user->hasRole('Admin')) {
            return Event::query()
                ->where('startDateTime', '>=', $fetchInfo['start'])
                ->where('endDateTime', '<=', $fetchInfo['end'])
                ->get()
                ->map(
                    fn(Event $event) => [
                        'id' => $event->id,
                        'title' => $event->name,
                        'color' => $event->colorId,
                        'start' => $event->startDateTime,
                        'end' => $event->endDateTime,
                        'url' => EventResource::getUrl(name: 'edit', parameters: ['record' => $event]),
                        'shouldOpenUrlInNewTab' => false,
                    ]
                )
                ->all();
        } else {
            return Event::query()
                ->where('startDateTime', '>=', $fetchInfo['start'])
                ->where('endDateTime', '<=', $fetchInfo['end'])
                ->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->get()
                ->map(
                    fn(Event $event) => [
                        'id' => $event->id,
                        'title' => $event->name,
                        'color' => $event->colorId,
                        'start' => $event->startDateTime,
                        'end' => $event->endDateTime,
                        'url' => EventResource::getUrl(name: 'edit', parameters: ['record' => $event]),
                        'shouldOpenUrlInNewTab' => false,
                    ]
                )
                ->all();
        }
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name'),
            ColorPicker::make('colorId'),

            Grid::make()
                ->schema([
                    DateTimePicker::make('startDateTime'),
                    DateTimePicker::make('endDateTime'),
                ]),
        ];
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Event')
        ];
    }

    protected function viewAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\ViewAction::make()
            ->modalFooterActions(fn(ViewAction $action) => [
                EditAction::make(),
                DeleteAction::make(),
                $action->getModalCancelAction(),
            ]);
    }

    protected function modalActions(): array
    {
        return [
            CreateAction::make()
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        $form->fill([
                            'startDateTime' => $arguments['event'] ?? null,
                            'endDateTime' => $arguments['event'] ?? null
                        ]);
                    }
                ),

            EditAction::make()
                ->mountUsing(
                    function (Event $record, Form $form, array $arguments) {
                        $form->fill([
                            'name' => $record->name,
                            'colorId' => $record->colorId,
                            'startDateTime' => $arguments['event']['start'] ?? $record->startDateTime,
                            'endDateTime' => $arguments['event']['end'] ?? $record->endDateTime
                        ]);
                    }
                ),
            DeleteAction::make(),
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
            el.setAttribute("x-tooltip", "tooltip");
            el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
        }
    JS;
    }
}
