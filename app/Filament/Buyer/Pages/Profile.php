<?php

namespace App\Filament\Buyer\Pages;

use App\Models\Clients;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.buyer.pages.profile';

    public function getViewData(): array
    {
        $client = Clients::where('email',auth()->user()->email)->first();
        return $client->toData();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('first_name')->required(),
            Forms\Components\TextInput::make('last_name')->required(),
            Forms\Components\TextInput::make('email')->required()->email(),
        ];
    }

    public function submit()
    {
        // Handle form submission logic
    }

}
