<?php

namespace App\Filament\User\Resources\DocumentResource\Pages;

use App\Actions\GenerateQR;
use App\Actions\ViewQR;
use App\Filament\User\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generateQR')
                ->label('Generate QR')
                ->icon('heroicon-o-qr-code')
                ->modalWidth('md')
                ->modalContent(function () {
                    $qrCode = (new \App\Actions\GenerateQR())->__invoke($this->record->code, [
                        'title' => $this->record->title,
                        'classification' => $this->record->classification?->name,
                    ]);
                    return view('components.qr-code', ['qrCode' => $qrCode]);
                })
                ->modalActions([
                    Actions\Action::make('download')
                        ->label('Download QR')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function () {
                            $qrCode = (new \App\Actions\GenerateQR())->__invoke($this->record->code, [
                                'title' => $this->record->title,
                                'classification' => $this->record->classification?->name,
                            ]);

                            return response()->streamDownload(function () use ($qrCode) {
                                echo base64_decode($qrCode);
                            }, "document-{$this->record->code}-qr.svg", [
                                'Content-Type' => 'image/svg+xml',
                            ]);
                        }),
                ]),
            Actions\DeleteAction::make(),
        ];
    }
}
