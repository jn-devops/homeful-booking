<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Notifications\ApprovalNotification;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Homeful\KwYCCheck\Models\Lead;
use Homeful\References\Data\ReferenceData;
use Homeful\References\Models\Reference;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Notification;
use Homeful\Notifications\Notifications\AcknowledgementReceiptBuyerNotification;
class ViewClient extends ViewRecord
{
    protected static string $resource = ContactResource::class;
    public function getTitle(): string | Htmlable
    {
        return __($this->record->fullName);
    }

    public function getSubheading(): string | Htmlable
    {
        return __('Reference Code: '.$this->record->reference_code);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Acknowledgement Receipt')
                ->action(function($record){

//                    $lead = Lead::first();
//                    $reference = Reference::first();
//                    $referenceData= ReferenceData::fromModel($reference);
//                    dd($referenceData);
//                    Notification::send($this->record, new AcknowledgementReceiptBuyerNotification($referenceData));
                    $this->record->notify(new ApprovalNotification());
                }),
        ];
    }

}
