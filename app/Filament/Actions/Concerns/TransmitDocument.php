<?php

namespace App\Filament\Actions\Concerns;

use App\Models\Document;
use App\Models\Office;
use App\Models\Section;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait TransmitDocument
{
    protected function getTransmitForm(): array
    {
        return [
            Select::make('office_id')
                ->label('Office')
                ->options(Office::pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    if (!$state) {
                        $set('section_id', null);
                    }
                }),

            Select::make('section_id')
                ->label('Section')
                ->options(function (Get $get) {
                    $officeId = $get('office_id');

                    if (!$officeId) {
                        return [];
                    }

                    $office = Office::find($officeId);

                    if (!$office || $office->id !== Auth::user()->office_id) {
                        return [];
                    }

                    return Section::where('office_id', $officeId)
                        ->pluck('name', 'id');
                })
                ->searchable()
                ->preload()
                ->visible(fn(Get $get) => $get('office_id') === Auth::user()->office_id),

            Select::make('liaison_id')
                ->label('Liaison')
                ->options(function () {
                    return User::where('office_id', Auth::user()->office_id)
                        ->where('role', 'liaison')
                        ->pluck('name', 'id');
                })
                ->searchable()
                ->preload()
                ->required(),

            Textarea::make('purpose')
                ->label('Purpose')
                ->required()
                ->maxLength(1000)
                ->columnSpanFull(),

            Textarea::make('remarks')
                ->label('Remarks')
                ->nullable()
                ->maxLength(1000)
                ->columnSpanFull(),
        ];
    }

    protected function handleTransmit(Document $record, array $data): void
    {
        try {
            DB::transaction(function () use ($record, $data) {
                if (!$record->isPublished()) {
                    throw new \Exception('Only published documents can be transmitted.');
                }

                if ($record->user_id !== Auth::id()) {
                    throw new \Exception('You can only transmit documents you created.');
                }

                if ($record->dissemination) {
                    throw new \Exception('This document is marked for dissemination and cannot be transmitted.');
                }

                // Verify that the selected liaison belongs to the user's office
                $liaison = User::where('id', $data['liaison_id'])
                    ->where('office_id', Auth::user()->office_id)
                    ->where('role', 'liaison')
                    ->first();

                if (!$liaison) {
                    throw new \Exception('The selected liaison is not valid for your office.');
                }

                // TODO: Implement actual transmission logic here
                // This could involve calling a service or triggering an event

                $record->update([
                    'transmitted_at' => now(),
                    'transmitted_to_office_id' => $data['office_id'],
                    'transmitted_to_section_id' => $data['section_id'],
                    'liaison_id' => $data['liaison_id'],
                    'transmission_purpose' => $data['purpose'],
                    'transmission_remarks' => $data['remarks'],
                ]);
            });

            // Success notification
            Notification::make()
                ->title('Document Transmitted Successfully')
                ->body("Document '{$record->title}' has been transmitted successfully.")
                ->success()
                ->send();
        } catch (\Exception $e) {
            // Error notification
            Notification::make()
                ->title('Transmission Failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function shouldShowTransmitAction(Document $record): bool
    {
        return $record->isPublished() &&
            $record->user_id === Auth::id() &&
            !$record->transmitted_at &&
            !$record->dissemination;
    }
}
