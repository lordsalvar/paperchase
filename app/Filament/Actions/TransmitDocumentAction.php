<?php

namespace App\Filament\Actions;

use App\Filament\Actions\Concerns\TransmitDocument;
use App\Models\Document;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransmitDocumentAction extends Action
{
    use TransmitDocument;

    protected function setUp(): void
    {
        parent::setUp();

        $this->name('transmit-document');

        $this->label('Transmit');

        $this->icon('heroicon-o-paper-airplane');

        $this->color('success');

        $this->modalSubmitActionLabel('Transmit');

        $this->modalHeading('Transmit Document');

        $this->modalDescription('This will transmit the document to the selected recipients. The document will be sent via the configured transmission method.');

        $this->requiresConfirmation();

        $this->modalIcon('heroicon-o-paper-airplane');

        $this->form($this->getTransmitForm());

        $this->action(function (Document $record, array $data): void {
            $this->handleTransmit($record, $data);
        });

        $this->visible(fn(Document $record): bool => $this->shouldShowTransmitAction($record));
    }

    protected function handleTransmit(Document $record, array $data): void
    {
        try {
            DB::transaction(function () use ($record) {
                if (!$record->isPublished()) {
                    throw new \Exception('Only published documents can be transmitted.');
                }

                if ($record->user_id !== Auth::id()) {
                    throw new \Exception('You can only transmit documents you created.');
                }

                // TODO: Implement actual transmission logic here
                // This could involve calling a service or triggering an event

                $record->update([
                    'transmitted_at' => now(),
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
}
