<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
// use Homeful\Contacts\Models\Contact;
use App\Models\Clients;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\ActionsPosition;
class ContactResource extends Resource
{
    protected static ?string $model = Clients::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference_code')
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_suffix')
                    ->maxLength(255),
                Forms\Components\TextInput::make('civil_status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sex')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nationality')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mobile')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('other_mobile')
                    ->maxLength(255),
                Forms\Components\TextInput::make('help_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('landline')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mothers_maiden_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('spouse'),
                Forms\Components\TextInput::make('addresses'),
                Forms\Components\TextInput::make('employment'),
                Forms\Components\TextInput::make('co_borrowers'),
                Forms\Components\TextInput::make('order'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(50)
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Status')
                    ->formatStateUsing(function (Clients $record) {
                        $statusDescription = $record->status ? $record->status->description : null;
                        $createdAt = $record->created_at ? $record->created_at->format('M d, Y') : null;

                        return $statusDescription . '<br> Date Created: <br>' . $createdAt;
                    })
                    ->html(true)
                    ->searchable(['current_status']),
                Tables\Columns\TextColumn::make('order.sku')
                    ->label('Property Details')
                    ->formatStateUsing(function (Clients $record) {
                        $data = $record->toData();
                        $projectName = isset($data['order']['project_name']) ? $data['order']['project_name'] : null;
                        $house_color = isset($data['order']['house_color']) ? $data['order']['house_color'] : null;
                        $loan_term = isset($data['order']['loan_term']) ? $data['order']['loan_term'] : null;
                        $seller_commission_code = isset($data['order']['seller_commission_code']) ? $data['order']['seller_commission_code'] : null;
                        $financial_scheme = isset($data['order']['payment_scheme']['scheme']) ? $data['order']['payment_scheme']['scheme'] : null;

                        return "<table>
                                <tr>
                                    <td colspan='2'><strong>" . $projectName . " - " . $house_color . "</strong></td>
                                </tr>
                                <tr>
                                    <td>Financial Scheme:</td>
                                    <td>".$financial_scheme."</td>
                                </tr>
                                <tr>
                                    <td>BP Loan Term:</td>
                                    <td>".$loan_term."</td>
                                </tr>
                                <tr>
                                    <td>PBL:</td>
                                    <td>".$loan_term."</td>
                                </tr>
                                <tr>
                                    <td>Source of Sale:</td>
                                    <td>".$seller_commission_code."</td>
                                </tr>
                            </table>";
                    })
                    ->html(true),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Personal Details')
                    ->formatStateUsing(function (Clients $record) {
                        $data = $record->toData();
                        $nationality = isset($data['profile']['nationality']) ? $data['profile']['nationality'] : null;
                        $civil_status = isset($data['profile']['civil_status']) ? $data['profile']['civil_status'] : null;
                        $age = isset($data['profile']['date_of_birth']) ? \Carbon\Carbon::parse($data['profile']['date_of_birth'])->age : null;
                        $name = trim(($data['profile']['first_name'] ?? '') . ' ' . ($data['profile']['middle_name'] ?? '') . ' ' . ($data['profile']['last_name'] ?? ''));
                        return "<table>
                                <tr>
                                    <td colspan='2'><strong>" . $name. "</strong></td>
                                </tr>
                                <tr>
                                    <td>Citizenship:</td>
                                    <td>".$nationality."</td>
                                </tr>
                                <tr>
                                    <td>Age:</td>
                                    <td>".$age." years old</td>
                                </tr>
                                <tr>
                                    <td>Civil Status:</td>
                                    <td>".$civil_status."</td>
                                </tr>
                            </table>";
                    })
                    ->html(true)
                    ->searchable(['first_name', 'middle_name', 'last_name']),
                Tables\Columns\TextColumn::make('tenure')
                    ->label('Employment Details')
                    ->formatStateUsing(function (Clients $record) {
                        // $data = $record->toData();
                        // $employment_type = isset($record->employment[0]['employment_type']) ? $record->employment[0]['employment_type'] : null;
                        // $monthly_gross_income = isset($record->employment[0]['monthly_gross_income']) ? $record->employment[0]['monthly_gross_income'] : null;
                        // $industry = isset($record->employment[0]['employer']['industry']) ? $record->employment[0]['employer']['industry'] : null;
                        // $country = isset($record->employment[0]['employer']['address']['country']) ? $record->employment[0]['employer']['address']['country'] : null;

                        $years_in_service = isset($record->employment['years_in_service']) ? $record->employment['years_in_service'] : 0;
                        $employment_type = isset($record->employment['employment_type']) ? $record->employment['employment_type'] : null;
                        $monthly_gross_income = isset($record->employment['monthly_gross_income']) ? $record->employment['monthly_gross_income'] : 0;
                        $industry = isset($record->employment['employer']['industry']) ? $record->employment['employer']['industry'] : null;
                        $country = isset($record->employment['employer']['address']['country']) ? $record->employment['employer']['address']['country'] : null;

                        return "<table>
                                <tr>
                                    <td>Tenure:</td>
                                    <td>".$years_in_service." yrs</td>
                                </tr>
                                <tr>
                                    <td>Employment Type:</td>
                                    <td>".$employment_type."</td>
                                </tr>
                                <tr>
                                    <td>Gross Monthy Income:</td>
                                    <td>".'₱' . number_format($monthly_gross_income, 2)."</td>
                                </tr>
                                <tr>
                                    <td>GMI Ratio(30%):</td>
                                    <td>".'₱' . number_format($monthly_gross_income*0.3, 2)."</td>
                                </tr>
                                <tr>
                                    <td>Industry</td>
                                    <td>".$industry."</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>".$country."</td>
                                </tr>
                            </table>";
                    })
                    ->html(true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),

            ],position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
            'view' => Pages\ViewClient::route('/{record}'),
        ];
    }
}
