<?php

namespace App\Filament\Admin\Resources\Loans\Pages;

use App\Enums\LoanStatus;
use App\Filament\Admin\Resources\Loans\LoanResource;
use App\Services\LoanService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class EditLoan extends EditRecord
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $newStatus = $data['status'];
        $oldStatus = $record->status?->value ?? $record->status;

        if ($newStatus !== $oldStatus) {
            $service = app(LoanService::class);

            try {
                if ($newStatus === LoanStatus::ACTIVE->value) {
                    return $service->confirmPickup($record->id);
                }

                if ($newStatus === LoanStatus::RETURNED->value) {
                    return $service->returnBook($record->id);
                }

                if ($newStatus === LoanStatus::CANCELLED->value) {
                    return $service->cancelLoan($record->id);
                }

                $record->update($data);
                return $record;

            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'status' => $e->getMessage(),
                ]);
            }
        }

        $record->update($data);
        return $record;
    }
}
