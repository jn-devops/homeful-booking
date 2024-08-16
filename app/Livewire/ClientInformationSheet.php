<?php

namespace App\Livewire;

use App\Filament\Resources\PhilippineCityResource;
use App\Models\CivilStatus;
use App\Models\CurrentPosition;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\NameSuffix;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use App\Models\Tenure;
use App\Models\WorkIndustry;
use App\Models\YearsOfOperation;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Collection;


class ClientInformationSheet extends Component  implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                   Wizard\Step::make('Buyer')
                        ->schema([
                            Fieldset::make('Personal')->schema([
                                TextInput::make('buyer.first_name')
                                    ->label('First Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(3),
                                TextInput::make('buyer.middle_name')
                                    ->label('Middle Name')
                                    ->maxLength(255)
                                    ->columnSpan(3),
                                TextInput::make('buyer.last_name')
                                    ->label('Last Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(3),
                                Select::make('buyer.name_suffix')
                                    ->label('Suffix')
                                    ->required()
                                    ->native(false)
                                    ->options(NameSuffix::all()->pluck('description','code'))
                                    ->columnSpan(3),
                                Select::make('buyer.civi_status')
                                    ->label('Civil Status')
                                    ->required()
                                    ->native(false)
                                    ->options(CivilStatus::all()->pluck('description','code'))
                                    ->columnSpan(3),
                                Select::make('buyer.gender')
                                    ->label('Gender')
                                    ->required()
                                    ->native(false)
                                    ->options([
                                        'Male'=>'Male',
                                        'Female'=>'Female'
                                    ])
                                    ->columnSpan(3),
                                DatePicker::make('buyer.date_of_birth')
                                    ->label('Date of Birth')
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(3),
                                TextInput::make('buyer.nationality')
                                    ->label('Nationality')
                                    ->maxLength(255)
                                    ->columnSpan(3),
                            ])->columns(12)->columnSpanFull(),
                            Fieldset::make('Contact Information')
                                ->schema([
                                    TextInput::make('buyer.email')
                                        ->label('E-Mail')
                                        ->email()
                                        ->maxLength(255)
                                        ->columnSpan(3),
                                    TextInput::make('buyer.mobile')
                                        ->required()
                                        ->prefix('+63')
                                        ->regex("/^[0-9]+$/")
                                        ->minLength(10)
                                        ->maxLength(10)
                                        ->live()
//                                        ->afterStateUpdated(function (Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) {
////                                            $livewire->validateOnly($component->getStatePath());
//                                        })
                                        ->columnSpan(3),
                                ])->columns(12)->columnSpanFull(),
                            Fieldset::make('Address')
                                ->schema([
                                    Fieldset::make('Present')->schema([
                                        Select::make('buyer.address.present.region')
                                            ->searchable()
                                            ->options(PhilippineRegion::all()->pluck('region_description','region_code'))
                                            ->required()
                                            ->native(false)
                                            ->live()
                                            ->afterStateUpdated(function(Set $set, $state){
                                                $set('buyer.address.present.province','');
                                                $set('buyer.address.present.city','');
                                                $set('buyer.address.present.barangay','');
                                            })
                                            ->columnSpan(3),
                                        Select::make('buyer.address.present.province')
                                            ->searchable()
                                            ->options(fn (Get $get): Collection => PhilippineProvince::query()
                                                ->where('region_code', $get('buyer.address.present.region'))
                                                ->pluck('province_description', 'province_code'))
                                            ->required()
                                            ->native(false)
                                            ->live()
                                            ->afterStateUpdated(function(Set $set, $state){
                                                $set('buyer.address.present.city','');
                                                $set('buyer.address.present.barangay','');
                                            })
                                            ->columnSpan(3),
                                        Select::make('buyer.address.present.city')
                                            ->searchable()
                                            ->options(fn (Get $get): Collection => PhilippineCity::query()
                                                ->where('province_code', $get('buyer.address.present.province'))
                                                ->pluck('city_municipality_description', 'city_municipality_code'))
                                            ->required()
                                            ->native(false)
                                            ->live()
                                            ->afterStateUpdated(function(Set $set, $state){
                                                $set('buyer.address.present.barangay','');
                                            })
                                            ->columnSpan(3),
                                        Select::make('buyer.address.present.barangay')
                                            ->searchable()
                                            ->options(fn (Get $get): Collection =>PhilippineBarangay::query()
                                                    ->where('region_code', $get('buyer.address.present.region'))
//                                                    ->where('province_code', $get('buyer.address.present.province'))                                            ->where('province_code', $get('province'))
                                                    ->where('city_municipality_code', $get('buyer.address.present.city'))
                                                    ->pluck('barangay_description', 'barangay_code')
                                            )
                                            ->required()
                                            ->native(false)
                                            ->live()
                                            ->columnSpan(3),
                                        TextInput::make('buyer.address.present.address')
                                            ->label('Address')
//                                        ->hint('Unit Number, House/Building/Street No, Street Name')
                                            ->placeholder('Unit Number, House/Building/Street No, Street Name')
                                            ->autocapitalize('words')
                                            ->maxLength(255)
                                            ->live()
                                            ->columnSpan(12),
                                        Placeholder::make('buyer.address.present.full_address')
                                            ->label('Full Address')
                                            ->live()
                                            ->content(function (Get $get): string {
                                                $region = PhilippineRegion::where('region_code', $get('buyer.address.present.region'))->first();
                                                $province = PhilippineProvince::where('province_code', $get('buyer.address.present.province'))->first();
                                                $city = PhilippineCity::where('city_municipality_code', $get('buyer.address.present.city'))->first();
                                                $barangay = PhilippineBarangay::where('barangay_code', $get('buyer.address.present.barangay'))->first();
                                                $address = $get('buyer.address.present.address');
                                                $addressParts = array_filter([
                                                    $address,
                                                    $barangay != null ? $barangay->barangay_description : '',
                                                    $city != null ? $city->city_municipality_description : '',
                                                    $province != null ? $province->province_description : '',
                                                    $region != null ? $region->region_description : '',
                                                ]);
                                                return implode(', ', $addressParts);
                                            })->columnSpan(10),
                                        Checkbox::make('buyer.address.present.same_as_permanent')
                                            ->label('Same as Permanent')
                                            ->inline(false)
                                            ->live()
                                            ->columnSpan(2),

                                    ])->columns(12)->columnSpanFull(),
                                    Group::make()->schema(
                                        fn(Get $get)=>$get('buyer.address.present.same_as_permanent')==null?[
                                            Fieldset::make('Permanent')->schema([
                                                Select::make('buyer.address.permanent.region')
                                                    ->searchable()
                                                    ->options(PhilippineRegion::all()->pluck('region_description','region_code'))
                                                    ->required()
                                                    ->native(false)
                                                    ->live()
                                                    ->afterStateUpdated(function(Set $set, $state){
                                                        $set('buyer.address.permanent.province','');
                                                        $set('buyer.address.permanent.city','');
                                                        $set('buyer.address.permanent.barangay','');
                                                    })
                                                    ->columnSpan(3),
                                                Select::make('buyer.address.permanent.province')
                                                    ->searchable()
                                                    ->options(fn (Get $get): Collection => PhilippineProvince::query()
                                                        ->where('region_code', $get('buyer.address.permanent.region'))
                                                        ->pluck('province_description', 'province_code'))
                                                    ->required()
                                                    ->native(false)
                                                    ->live()
                                                    ->afterStateUpdated(function(Set $set, $state){
                                                        $set('buyer.address.permanent.city','');
                                                        $set('buyer.address.permanent.barangay','');
                                                    })
                                                    ->columnSpan(3),
                                                Select::make('buyer.address.permanent.city')
                                                    ->searchable()
                                                    ->options(fn (Get $get): Collection => PhilippineCity::query()
                                                        ->where('province_code', $get('buyer.address.permanent.province'))
                                                        ->pluck('city_municipality_description', 'city_municipality_code'))
                                                    ->required()
                                                    ->native(false)
                                                    ->live()
                                                    ->afterStateUpdated(function(Set $set, $state){
                                                        $set('buyer.address.permanent.barangay','');
                                                    })
                                                    ->columnSpan(3),
                                                Select::make('buyer.address.permanent.barangay')
                                                    ->searchable()
                                                    ->options(fn (Get $get): Collection =>PhilippineBarangay::query()
                                                        ->where('region_code', $get('buyer.address.permanent.region'))
//                                                    ->where('province_code', $get('buyer.address.present.province'))                                            ->where('province_code', $get('province'))
                                                        ->where('city_municipality_code', $get('buyer.address.permanent.city'))
                                                        ->pluck('barangay_description', 'barangay_code')
                                                    )
                                                    ->required()
                                                    ->native(false)
                                                    ->live()
                                                    ->columnSpan(3),
                                                TextInput::make('buyer.address.permanent.address')
                                                    ->label('Address')
//                                        ->hint('Unit Number, House/Building/Street No, Street Name')
                                                    ->placeholder('Unit Number, House/Building/Street No, Street Name')
                                                    ->autocapitalize('words')
                                                    ->maxLength(255)
                                                    ->live()
                                                    ->columnSpan(12),
                                                Placeholder::make('buyer.address.permanent.full_address')
                                                    ->label('Full Address')
                                                    ->live()
                                                    ->content(function (Get $get): string {
                                                        $region = PhilippineRegion::where('region_code', $get('buyer.address.permanent.region'))->first();
                                                        $province = PhilippineProvince::where('province_code', $get('buyer.address.permanent.province'))->first();
                                                        $city = PhilippineCity::where('city_municipality_code', $get('buyer.address.permanent.city'))->first();
                                                        $barangay = PhilippineBarangay::where('barangay_code', $get('buyer.address.permanent.barangay'))->first();
                                                        $address = $get('buyer.address.permanent.address');
                                                        $addressParts = array_filter([
                                                            $address,
                                                            $barangay != null ? $barangay->barangay_description : '',
                                                            $city != null ? $city->city_municipality_description : '',
                                                            $province != null ? $province->province_description : '',
                                                            $region != null ? $region->region_description : '',
                                                        ]);
                                                        return implode(', ', $addressParts);
                                                    })->columnSpan(12),


                                            ])->columns(12)->columnSpanFull(),
                                        ]:[]
                                    )->columns(12)->columnSpanFull(),
                                ])->columns(12)->columnSpanFull(),

                        ])->columns(12)->columnSpanFull(),
                   Wizard\Step::make('Spouse')
                     ->schema([
                         Fieldset::make('Personal')->schema([
                             TextInput::make('spouse.first_name')
                                 ->label('First Name')
                                 ->required()
                                 ->maxLength(255)
                                 ->columnSpan(3),
                             TextInput::make('spouse.middle_name')
                                 ->label('Middle Name')
                                 ->maxLength(255)
                                 ->columnSpan(3),
                             TextInput::make('spouse.last_name')
                                 ->label('Last Name')
                                 ->required()
                                 ->maxLength(255)
                                 ->columnSpan(3),
                             Select::make('spouse.name_suffix')
                                 ->label('Suffix')
                                 ->required()
                                 ->native(false)
                                 ->options(NameSuffix::all()->pluck('description','code'))
                                 ->columnSpan(3),
                             Select::make('spouse.civil_status')
                                 ->label('Civil Status')
                                 ->required()
                                 ->native(false)
                                 ->options(CivilStatus::all()->pluck('description','code'))
                                 ->columnSpan(3),
                             Select::make('spouse.gender')
                                 ->label('Gender')
                                 ->required()
                                 ->native(false)
                                 ->options([
                                     'Male'=>'Male',
                                     'Female'=>'Female'
                                 ])
                                 ->columnSpan(3),
                             DatePicker::make('spouse.date_of_birth')
                                 ->label('Date of Birth')
                                 ->required()
                                 ->native(false)
                                 ->columnSpan(3),
                             TextInput::make('spouse.nationality')
                                 ->label('Nationality')
                                 ->maxLength(255)
                                 ->columnSpan(3),
                         ])->columns(12)->columnSpanFull(),
                         Fieldset::make('Contact Information')
                             ->schema([
                                 TextInput::make('spouse.email')
                                     ->label('E-Mail')
                                     ->email()
                                     ->maxLength(255)
                                     ->columnSpan(3),
                                 TextInput::make('spouse.mobile')
                                     ->required()
                                     ->prefix('+63')
                                     ->regex("/^[0-9]+$/")
                                     ->minLength(10)
                                     ->maxLength(10)
                                     ->live()
//                                        ->afterStateUpdated(function (Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) {
////                                            $livewire->validateOnly($component->getStatePath());
//                                        })
                                     ->columnSpan(3),
                             ])->columns(12)->columnSpanFull(),
                         Fieldset::make('Address')
                             ->schema([
                                 Checkbox::make('spouse.address.same_as_buyer')
                                     ->label('Same as Buyer')
                                     ->inline(false)
                                     ->live()
                                     ->columnSpanFull(),
                                 Group::make()->schema(fn(Get $get)=>$get('spouse.address.same_as_buyer')!=null?[]:[
                                     Fieldset::make('Present')->schema([
                                         Select::make('spouse.address.present.region')
                                             ->searchable()
                                             ->options(PhilippineRegion::all()->pluck('region_description','region_code'))
                                             ->required()
                                             ->native(false)
                                             ->live()
                                             ->afterStateUpdated(function(Set $set, $state){
                                                 $set('spouse.address.present.province','');
                                                 $set('spouse.address.present.city','');
                                                 $set('spouse.address.present.barangay','');
                                             })
                                             ->columnSpan(3),
                                         Select::make('spouse.address.present.province')
                                             ->searchable()
                                             ->options(fn (Get $get): Collection => PhilippineProvince::query()
                                                 ->where('region_code', $get('spouse.address.present.region'))
                                                 ->pluck('province_description', 'province_code'))
                                             ->required()
                                             ->native(false)
                                             ->live()
                                             ->afterStateUpdated(function(Set $set, $state){
                                                 $set('spouse.address.present.city','');
                                                 $set('spouse.address.present.barangay','');
                                             })
                                             ->columnSpan(3),
                                         Select::make('spouse.address.present.city')
                                             ->searchable()
                                             ->options(fn (Get $get): Collection => PhilippineCity::query()
                                                 ->where('province_code', $get('spouse.address.present.province'))
                                                 ->pluck('city_municipality_description', 'city_municipality_code'))
                                             ->required()
                                             ->native(false)
                                             ->live()
                                             ->afterStateUpdated(function(Set $set, $state){
                                                 $set('spouse.address.present.barangay','');
                                             })
                                             ->columnSpan(3),
                                         Select::make('spouse.address.present.barangay')
                                             ->searchable()
                                             ->options(fn (Get $get): Collection =>PhilippineBarangay::query()
                                                 ->where('region_code', $get('spouse.address.present.region'))
//                                                    ->where('province_code', $get('buyer.address.present.province'))                                            ->where('province_code', $get('province'))
                                                 ->where('city_municipality_code', $get('spouse.address.present.city'))
                                                 ->pluck('barangay_description', 'barangay_code')
                                             )
                                             ->required()
                                             ->native(false)
                                             ->live()
                                             ->columnSpan(3),
                                         TextInput::make('spouse.address.present.address')
                                             ->label('Address')
//                                        ->hint('Unit Number, House/Building/Street No, Street Name')
                                             ->placeholder('Unit Number, House/Building/Street No, Street Name')
                                             ->autocapitalize('words')
                                             ->maxLength(255)
                                             ->live()
                                             ->columnSpan(12),
                                         Placeholder::make('spouse.address.present.full_address')
                                             ->label('Full Address')
                                             ->live()
                                             ->content(function (Get $get): string {
                                                 $region = PhilippineRegion::where('region_code', $get('spouse.address.present.region'))->first();
                                                 $province = PhilippineProvince::where('province_code', $get('spouse.address.present.province'))->first();
                                                 $city = PhilippineCity::where('city_municipality_code', $get('spouse.address.present.city'))->first();
                                                 $barangay = PhilippineBarangay::where('barangay_code', $get('spouse.address.present.barangay'))->first();
                                                 $address = $get('spouse.address.present.address');
                                                 $addressParts = array_filter([
                                                     $address,
                                                     $barangay != null ? $barangay->barangay_description : '',
                                                     $city != null ? $city->city_municipality_description : '',
                                                     $province != null ? $province->province_description : '',
                                                     $region != null ? $region->region_description : '',
                                                 ]);
                                                 return implode(', ', $addressParts);
                                             })->columnSpan(10),
                                         Checkbox::make('spouse.address.present.same_as_permanent')
                                             ->label('Same as Permanent')
                                             ->inline(false)
                                             ->live()
                                             ->columnSpan(2),

                                     ])->columns(12)->columnSpanFull(),
                                     Group::make()->schema(
                                         fn(Get $get)=>$get('spouse.address.present.same_as_permanent')==null?[
                                             Fieldset::make('Permanent')->schema([
                                                 Select::make('spouse.address.permanent.region')
                                                     ->searchable()
                                                     ->options(PhilippineRegion::all()->pluck('region_description','region_code'))
                                                     ->required()
                                                     ->native(false)
                                                     ->live()
                                                     ->afterStateUpdated(function(Set $set, $state){
                                                         $set('spouse.address.permanent.province','');
                                                         $set('spouse.address.permanent.city','');
                                                         $set('spouse.address.permanent.barangay','');
                                                     })
                                                     ->columnSpan(3),
                                                 Select::make('spouse.address.permanent.province')
                                                     ->searchable()
                                                     ->options(fn (Get $get): Collection => PhilippineProvince::query()
                                                         ->where('region_code', $get('spouse.address.permanent.region'))
                                                         ->pluck('province_description', 'province_code'))
                                                     ->required()
                                                     ->native(false)
                                                     ->live()
                                                     ->afterStateUpdated(function(Set $set, $state){
                                                         $set('spouse.address.permanent.city','');
                                                         $set('spouse.address.permanent.barangay','');
                                                     })
                                                     ->columnSpan(3),
                                                 Select::make('spouse.address.permanent.city')
                                                     ->searchable()
                                                     ->options(fn (Get $get): Collection => PhilippineCity::query()
                                                         ->where('province_code', $get('spouse.address.permanent.province'))
                                                         ->pluck('city_municipality_description', 'city_municipality_code'))
                                                     ->required()
                                                     ->native(false)
                                                     ->live()
                                                     ->afterStateUpdated(function(Set $set, $state){
                                                         $set('spouse.address.permanent.barangay','');
                                                     })
                                                     ->columnSpan(3),
                                                 Select::make('spouse.address.permanent.barangay')
                                                     ->searchable()
                                                     ->options(fn (Get $get): Collection => PhilippineBarangay::query()
                                                         ->where('region_code', $get('spouse.address.permanent.region'))
//                                                         ->where('province_code', $get('spouse.address.permanent.province'))                                            ->where('province_code', $get('province'))
                                                         ->where('city_municipality_code', $get('spouse.address.permanent.city'))
                                                         ->pluck('barangay_description', 'barangay_code'))
                                                     ->required()
                                                     ->native(false)
                                                     ->live()
                                                     ->columnSpan(3),
                                                 TextInput::make('spouse.address.permanent.address')
                                                     ->label('Address')
                                                     ->placeholder('Unit Number, House/Building/Street No, Street Name')
                                                     ->maxLength(255)
                                                     ->live()
                                                     ->columnSpanFull(),
                                                 Placeholder::make('spouse.address.permanent.full_address')
                                                     ->label('Full Address')
                                                     ->live()
                                                     ->content(function (Get $get): string {
                                                         $region = PhilippineRegion::where('region_code', $get('spouse.address.permanent.region'))->first();
                                                         $province = PhilippineProvince::where('province_code', $get('spouse.address.permanent.province'))->first();
                                                         $city = PhilippineCity::where('city_municipality_code', $get('spouse.address.permanent.city'))->first();
                                                         $barangay = PhilippineBarangay::where('barangay_code', $get('spouse.address.permanent.barangay'))->first();
                                                         $address = $get('spouse.address.permanent.address');
                                                         $addressParts = array_filter([
                                                             $address,
                                                             $barangay != null ? $barangay->barangay_description : '',
                                                             $city != null ? $city->city_municipality_description : '',
                                                             $province != null ? $province->province_description : '',
                                                             $region != null ? $region->region_description : '',
                                                         ]);
                                                         return implode(', ', $addressParts);
                                                     })->columnSpanFull(),


                                             ])->columns(12)->columnSpanFull(),
                                         ]:[]
                                     )->columns(12)->columnSpanFull(),
                                 ]) ->columnSpanFull(),

                             ])->columns(12)->columnSpanFull(),

                     ])->columns(12)->columnSpanFull(),
                   Wizard\Step::make('Employement')
                       ->schema([
                           Fieldset::make('Employment')->schema([
                               Select::make('employment.type')
                                   ->label('Employment Type')
                                   ->required()
                                   ->native(false)
                                   ->options(EmploymentType::all()->pluck('description','code'))
                                   ->columnSpan(3),
                               Select::make('employment.status')
                                   ->label('Employment Status')
                                   ->required()
                                   ->native(false)
                                   ->options(EmploymentStatus::all()->pluck('description','code'))
                                   ->columnSpan(3),
                               Select::make('employment.tenure')
                                   ->label('Tenure')
                                   ->required()
                                   ->native(false)
                                   ->options(Tenure::all()->pluck('description','code'))
                                   ->columnSpan(3),
                               Select::make('employment.position')
                                   ->label('Current Position')
                                   ->required()
                                   ->native(false)
                                   ->options(CurrentPosition::all()->pluck('description','code'))
                                   ->searchable()
                                   ->columnSpan(3),
                               TextInput::make('employment.rank')
                                   ->label('Rank')
                                   ->required()
                                   ->maxLength(255)
                                   ->columnSpan(3),
                               Select::make('employment.work_industry')
                                   ->label('Work Industry')
                                   ->required()
                                   ->native(false)
                                   ->options(WorkIndustry::all()->pluck('description','code'))
                                   ->searchable()
                                   ->columnSpan(3),
                               TextInput::make('employment.gross_monthly_income')
                                   ->label('Gross Monthly Income')
                                   ->numeric()
                                   ->prefix('PHP')
                                   ->required()
                                   ->maxLength(255)
                                   ->columnSpan(3),
                               Group::make()->schema([
                                   TextInput::make('employment.tin')
                                       ->label('Tax Identification Number')
                                       ->required()
                                       ->maxLength(255)
                                       ->columnSpan(3),
                                   TextInput::make('employment.pag_ibig')
                                       ->label('PAG-IBIG Number')
                                       ->required()
                                       ->maxLength(255)
                                       ->columnSpan(3),
                                   TextInput::make('employment.sss_gsis')
                                       ->label('SSS/GSIS Number')
                                       ->required()
                                       ->maxLength(255)
                                       ->columnSpan(3),
                               ])->columnSpanFull()->columns(12),


                           ])->columns(12)->columnSpanFull(),
                           Fieldset::make('Employer/Business')->schema([
                               TextInput::make('employment.employer_business_name')
                                   ->label('Employer / Business Name')
                                   ->required()
                                   ->maxLength(255)
                                   ->columnSpan(3),
                               TextInput::make('employment.contact_person')
                                   ->label('Contact Person')
                                   ->required()
                                   ->maxLength(255)
                                   ->columnSpan(3),
                               TextInput::make('employment.employer_email')
                                   ->label('Email')
                                   ->email()
                                   ->required()
                                   ->maxLength(255)
                                   ->columnSpan(3),
                               TextInput::make('employment.mobile')
                                   ->label('Contact Number')
                                   ->required()
                                   ->prefix('+63')
                                   ->regex("/^[0-9]+$/")
                                   ->minLength(10)
                                   ->maxLength(10)
                                   ->live()
//                                        ->afterStateUpdated(function (Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $component) {
////                                            $livewire->validateOnly($component->getStatePath());
//                                        })
                                   ->columnSpan(3),
                               Select::make('employment.years_of_operation')
                                   ->label('Years of Operation')
                                   ->required()
                                   ->native(false)
                                   ->options(YearsOfOperation::all()->pluck('description','code'))
                                   ->columnSpan(3),
                               Fieldset::make('Address')->schema([
                                   Select::make('employment.address.present.region')
                                       ->searchable()
                                       ->options(PhilippineRegion::all()->pluck('region_description','region_code'))
                                       ->required()
                                       ->native(false)
                                       ->live()
                                       ->afterStateUpdated(function(Set $set, $state){
                                           $set('employment.address.present.province','');
                                           $set('employment.address.present.city','');
                                           $set('employment.address.present.barangay','');
                                       })
                                       ->columnSpan(3),
                                   Select::make('employment.address.present.province')
                                       ->searchable()
                                       ->options(fn (Get $get): Collection => PhilippineProvince::query()
                                           ->where('region_code', $get('employment.address.present.region'))
                                           ->pluck('province_description', 'province_code'))
                                       ->required()
                                       ->native(false)
                                       ->live()
                                       ->afterStateUpdated(function(Set $set, $state){
                                           $set('employment.address.present.city','');
                                           $set('employment.address.present.barangay','');
                                       })
                                       ->columnSpan(3),
                                   Select::make('employment.address.present.city')
                                       ->searchable()
                                       ->options(fn (Get $get): Collection => PhilippineCity::query()
                                           ->where('province_code', $get('employment.address.present.province'))
                                           ->pluck('city_municipality_description', 'city_municipality_code'))
                                       ->required()
                                       ->native(false)
                                       ->live()
                                       ->afterStateUpdated(function(Set $set, $state){
                                           $set('employment.address.present.barangay','');
                                       })
                                       ->columnSpan(3),
                                   Select::make('employment.address.present.barangay')
                                       ->searchable()
                                       ->options(fn (Get $get): Collection =>PhilippineBarangay::query()
                                           ->where('region_code', $get('employment.address.present.region'))
//                                                    ->where('province_code', $get('buyer.address.present.province'))                                            ->where('province_code', $get('province'))
                                           ->where('city_municipality_code', $get('employment.address.present.city'))
                                           ->pluck('barangay_description', 'barangay_code')
                                       )
                                       ->required()
                                       ->native(false)
                                       ->live()
                                       ->columnSpan(3),
                                   TextInput::make('employment.address.present.address')
                                       ->label('Address')
//                                        ->hint('Unit Number, House/Building/Street No, Street Name')
                                       ->placeholder('Unit Number, House/Building/Street No, Street Name')
                                       ->autocapitalize('words')
                                       ->maxLength(255)
                                       ->live()
                                       ->columnSpan(12),


                               ])->columns(12)->columnSpanFull(),
                           ])->columns(12)->columnSpanFull(),
                       ])->columns(12)->columnSpanFull(),
                   Wizard\Step::make('Files')
                      ->schema([
                          FileUpload::make('company_id')
                              ->label('Company ID')
                              ->openable()
                              ->downloadable()
                              ->image()
                              ->maxSize(15000)
                              ->imageEditor()
                              ->directory('client-information-attachments')
                              ->visibility('private')
                               ->imageEditorAspectRatios([
                                   null,
                               ]),
                          FileUpload::make('pagibig_id')
                              ->label('PAG-IBIG ID')
                              ->openable()
                              ->downloadable()
                              ->image()
                              ->maxSize(15000)
                              ->imageEditor()
                              ->directory('client-information-attachments')
                              ->visibility('private')
                              ->imageEditorAspectRatios([
                                  null,
                              ]),
                      ]),
                ])->persistStepInQueryString()
//                    ->startOnStep(4)
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Submit
                    </x-filament::button>
                    BLADE)))
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    #[Layout('layouts.app')]
    public function render():View
    {
        return view('livewire.client-information-sheet');
    }
}
