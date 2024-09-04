<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Models\Clients;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Models\Status;
class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public  function getTabs(): array
    {
        $statuses = Status::all();

        $tabs = [
            null => Tab::make('All')->badge($this->getBadgeCount(null)),
        ];

        foreach ($statuses as $status) {
            $tabs[$status->code] = Tab::make($status->description)
                ->badge($this->getBadgeCount($status->code))
                ->query(fn ($query) => $query->where('current_status_code', $status->code));
        }

        return $tabs;
    }
    protected function getBadgeCount(?string $statusCode = null): int
    {
        $query = Clients::query();

        if ($statusCode) {
            $query->where('current_status_code', $statusCode);
        }

        return $query->count();
    }
    public function getDefaultActiveTab(): string | int | null
    {
        return 'All';
    }
}
