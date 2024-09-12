<?php

namespace App\Filament\Buyer\Pages\Auth;

use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        DatePicker::make('date_of_birth')
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->format('M d, Y')
                            ->required(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

}
