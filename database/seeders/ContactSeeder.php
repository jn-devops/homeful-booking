<?php

namespace Database\Seeders;

use Homeful\Contacts\Models\Contact;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Faker\Generator as BaseGenerator;
use App\Models\Status;
class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a Faker instance with the 'en_PH' locale
//        $faker = FakerFactory::create('en_PH');
//        $customFaker = new CustomFakerGenerator();

        // Seed 10 contacts
//        foreach (range(1, 10) as $i) {
//            $status = Status::inRandomOrder()->first();
//            Contact::create([
//                'reference_code' => $faker->uuid(),
//                'first_name' => $faker->firstName(),
//                'middle_name' => $faker->lastName(),
//                'last_name' => $faker->lastName(),
//                'name_suffix' => $customFaker->nameSuffix(),
//                'civil_status' => $faker->randomElement(['Single', 'Married', 'Annulled/Divorced', 'Legally Seperated', 'Widow/er']),
//                'sex' => $faker->randomElement(['Male', 'Female']),
//                'nationality' => 'Filipino',
//                'date_of_birth' => $faker->date(),
//                'email' => $faker->email(),
//                'mobile' => $customFaker->phoneNumber(),
//                'other_mobile' => $customFaker->phoneNumber(),
//                'help_number' => $customFaker->phoneNumber(),
//                'landline' => $customFaker->phoneNumber(),
//                'mothers_maiden_name' => $faker->lastName() . ', ' . $faker->firstName() . ' ' . $faker->lastName(),
//                // Current Status and Current Status Code from Status Model
//                'current_status' => $status->description,
//                'current_status_code' => $status->code,
//
//
//                // Spouse data
//                'spouse' => [
//                    'first_name' => $faker->firstName(),
//                    'middle_name' => $faker->lastName(),
//                    'last_name' => $faker->lastName(),
//                    'name_suffix' => $customFaker->nameSuffix(),
//                    'civil_status' => $faker->randomElement(['Single', 'Married', 'Annulled/Divorced', 'Legally Seperated', 'Widow/er']),
//                    'sex' => $faker->randomElement(['Male', 'Female']),
//                    'nationality' => 'Filipino',
//                    'date_of_birth' => $faker->date(),
//                    'email' => $faker->email(),
//                    'mobile' => $customFaker->phoneNumber(),
//                    'other_mobile' => $customFaker->phoneNumber(),
//                    'help_number' => $customFaker->phoneNumber(),
//                    'landline' => $customFaker->phoneNumber(),
//                    'mothers_maiden_name' => $faker->lastName() . ', ' . $faker->firstName() . ' ' . $faker->lastName(),
//                ],
//
//                // Addresses data
//                'addresses' => [
//                    [
//                        'type' => 'Present',
//                        'ownership' => $faker->randomElement(['Owned', 'Rented']),
//                        'full_address' => $faker->optional()->address(),
//                        'address1' => $faker->streetAddress(), // street address
//                        'address2' => $faker->optional()->secondaryAddress(), // secondary address (optional)
//                        'locality' => $faker->city(), // city or municipality
//                        'administrative_area' => $faker->randomElement(['NCR', 'Metro Manila', 'Cebu']), // province or region
//                        'sublocality' => $faker->barangay(), // barangay
//                        'postal_code' => $faker->postcode(), // postal code
//                        'sorting_code' => $faker->optional()->postcode(), // optional sorting code
//                        'country' => 'PH', // country code (Philippines)
//                        'block' => $faker->optional()->buildingNumber(), // block (optional)
//                        'lot' => $faker->optional()->randomDigitNotNull(), // lot number (optional)
//                        'unit' => $faker->optional()->randomDigitNotNull(), // unit number (optional)
//                        'floor' => $faker->optional()->randomDigitNotNull(), // floor number (optional)
//                        'street' => $faker->streetName(), // street name
//                        'building' => $faker->optional()->word(), // building name (optional)
//                        'length_of_stay' => $faker->optional()->numberBetween(1, 10) . ' years', // length of stay in years (optional)
//                    ],
//                    [
//                        'type' => 'Permanent',
//                        'ownership' => $faker->randomElement(['Owned', 'Rented']),
//                        'full_address' => $faker->optional()->address(),
//                        'address1' => $faker->streetAddress(), // street address
//                        'address2' => $faker->optional()->secondaryAddress(), // secondary address (optional)
//                        'locality' => $faker->city(), // city or municipality
//                        'administrative_area' => $faker->randomElement(['NCR', 'Metro Manila', 'Cebu']), // province or region
//                        'sublocality' => $faker->barangay(), // barangay
//                        'postal_code' => $faker->postcode(), // postal code
//                        'sorting_code' => $faker->optional()->postcode(), // optional sorting code
//                        'country' => 'PH', // country code (Philippines)
//                        'block' => $faker->optional()->buildingNumber(), // block (optional)
//                        'lot' => $faker->optional()->randomDigitNotNull(), // lot number (optional)
//                        'unit' => $faker->optional()->randomDigitNotNull(), // unit number (optional)
//                        'floor' => $faker->optional()->randomDigitNotNull(), // floor number (optional)
//                        'street' => $faker->streetName(), // street name
//                        'building' => $faker->optional()->word(), // building name (optional)
//                        'length_of_stay' => $faker->optional()->numberBetween(1, 10) . ' years', // length of stay in years (optional)
//                    ],
//                ],
//
//                // Employment data
//                'employment' => [
//                    [
//                        'type' => 'buyer',
//                        'employment_status' => $faker->word(),
//                        'monthly_gross_income' => $faker->numberBetween(12000, 25000) * 100,
//                        'current_position' => $faker->word(),
//                        'employment_type' => $faker->word(),
//                        'employer' => [
//                            'name' => $faker->company(),
//                            'industry' => $faker->word(),
//                            'nationality' => $faker->randomElement(['Filipino', 'Foreign']),
//                            'address' => [
//                                'type' => 'work',
//                                'ownership' => $faker->word(),
//                                'address1' => $faker->address(),
//                                'locality' => $faker->city(),
//                                'postal_code' => $faker->postcode(),
//                                'country' => 'PH',
//                            ],
//                            'contact_no' => $faker->phoneNumber(),
//                        ],
//                        'id' => [
//                            'tin' => $faker->numerify('###-###-###'),
//                            'pagibig' => $faker->numerify('###########'),
//                            'sss' => $faker->numerify('##-#######-#'),
//                            'gsis' => $faker->numerify('#########'),
//                        ],
//                    ],
//                ],
//
//                // Co-borrowers data
//                'co_borrowers' => [
//                    [
//                        'first_name' => $faker->firstName(),
//                        'middle_name' => $faker->lastName(),
//                        'last_name' => $faker->lastName(),
//                        'civil_status' => $faker->randomElement(['Single', 'Married', 'Annulled/Divorced', 'Legally Seperated', 'Widow/er']),
//                        'sex' => $faker->randomElement(['Male', 'Female']),
//                        'nationality' => 'Filipino',
//                        'date_of_birth' => $faker->date(),
//                        'email' => $faker->email(),
//                        'mobile' => $customFaker->phoneNumber(),
//                    ],
//                    [
//                        'first_name' => $faker->firstName(),
//                        'middle_name' => $faker->lastName(),
//                        'last_name' => $faker->lastName(),
//                        'civil_status' => $faker->randomElement(['Single', 'Married', 'Annulled/Divorced', 'Legally Seperated', 'Widow/er']),
//                        'sex' => $faker->randomElement(['Male', 'Female']),
//                        'nationality' => 'Filipino',
//                        'date_of_birth' => $faker->date(),
//                        'email' => $faker->email(),
//                        'mobile' => $customFaker->phoneNumber(),
//                    ],
//                ],
//
//                // Order data
//                'order' => [
//                    'sku' => $faker->word(),
//                    'seller_commission_code' => $faker->word(),
//                    'property_code' => $faker->word(),
//                    'payment_scheme' => [
//                        'payments' => [],
//                        'fees' => [],
//                    ],
//                    'seller' => [],
//                ],
//
//                // Other media data
//                'idImage' => null,
//                'selfieImage' => null,
//                'payslipImage' => null,
//                'voluntarySurrenderFormDocument' => null,
//                'usufructAgreementDocument' => null,
//                'contractToSellDocument' => null,
//            ]);
//        }
    }
}
//class CustomFakerGenerator extends BaseGenerator
//{
//    public function nameSuffix()
//    {
//        $suffixes = ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V'];
//        return $this->randomElement($suffixes);
//    }
//
//    public function phoneNumber(): string
//    {
//        $randomNumber = str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
//        return '+639' . $randomNumber;
//    }
//
//    public function randomElement(array $array)
//    {
//        if (empty($array)) {
//            throw new InvalidArgumentException('Array cannot be empty.');
//        }
//        return $array[array_rand($array)];
//    }
//}
