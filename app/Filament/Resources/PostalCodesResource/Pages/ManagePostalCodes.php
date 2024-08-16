<?php

namespace App\Filament\Resources\PostalCodesResource\Pages;

use App\Filament\Resources\PostalCodesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePostalCodes extends ManageRecords
{
    protected static string $resource = PostalCodesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
