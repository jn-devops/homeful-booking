<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
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
}
