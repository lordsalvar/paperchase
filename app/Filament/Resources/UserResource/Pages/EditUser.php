<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('change_password')
                ->label('Change Password')
                ->icon('heroicon-o-key')
                ->form([
                    \Filament\Forms\Components\TextInput::make('password')
                        ->label('New Password')
                        ->password()
                        ->required()
                        ->minLength(8),
                ])
                ->action(function (array $data, User $record): void {
                    $record->update([
                        'password' => bcrypt($data['password']),
                    ]);
                })
                ->hidden(fn (User $record) => $record->trashed())
                ->requiresConfirmation()
                ->color('warning'),
            Actions\Action::make('restore_user')
                ->label('Restore User')
                ->icon('heroicon-o-arrow-uturn-left')
                ->visible(fn (User $record) => $record->trashed())
                ->action(fn (User $record) => $record->restore())
                ->color('success'),
            ActionGroup::make([
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(function (User $record): void {
                        $record->delete();
                    })
                    ->color('danger')
                    ->label('Delete'),
                ForceDeleteAction::make()
                    ->requiresConfirmation()
                    ->action(function (User $record): void {
                        $record->forceDelete();
                    })
                    ->color('danger')
                    ->label('Permanently Delete'),

            ])
                ->label('Danger Actions')
                ->icon('heroicon-o-ellipsis-vertical'),
        ];
    }

    protected function saved(): void
    {
        parent::saved();

        \Filament\Notifications\Notification::make()
            ->title('Password changed successfully')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        // Hide save/cancel if the user is soft-deleted
        return $this->getRecord()->trashed() ? [] : parent::getFormActions();
    }
}
