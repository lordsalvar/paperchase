<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Actions\TransmitDocumentAction;
use App\Filament\Actions\ViewDocumentHistoryAction;
use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            TransmitDocumentAction::make(),
            ViewDocumentHistoryAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
