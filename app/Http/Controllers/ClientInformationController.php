<?php

namespace App\Http\Controllers;

use App\Models\CivilStatus;
use App\Models\HomeOwnership;
use App\Models\NameSuffix;
use App\Models\Nationality;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use Homeful\KwYCCheck\Models\Lead;
use Homeful\References\Models\Reference;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Homeful\Contacts\Actions\PersistContactAction;
use Homeful\Contacts\Models\Contact;
use Illuminate\Validation\ValidationException;
use Homeful\KwYCCheck\Actions\CreateLeadContactAction;
class ClientInformationController extends Controller
{
    public function show(String $kwyc_code)
    {
        $lead = Lead::where('meta->checkin->body->code', $kwyc_code)->first();
        $fieldsExtracted = $lead->meta['checkin']['body']['data']['fieldsExtracted'];

        $provinces = PhilippineProvince::all()->map(function($province) {
            return [
                'region_code' => $province->region_code,
                'province_code' => $province->province_code,
                'province_description' => $province->province_description,
            ];
        })->toArray();

        $cities = PhilippineCity::all()->map(function($city) {
            return [
                'province_code' => $city->province_code,
                'city_municipality_code' => $city->city_municipality_code,
                'city_municipality_description' => $city->city_municipality_description,
            ];
        })->toArray();

        $barangays = PhilippineBarangay::all()->map(function($barangay) {
            return [
                'city_municipality_code' => $barangay->city_municipality_code,
                'barangay_code' => $barangay->barangay_code,
                'barangay_description' => $barangay->barangay_description,
            ];
        })->toArray();

        return Inertia::render('ClientInformation', [
            'name_suffixes'=>NameSuffix::all()->pluck('code','description')->toArray(),
            'nationalities'=>Nationality::all()->pluck('code','description')->toArray(),
            'civil_statuses'=>CivilStatus::all()->pluck('code','description')->toArray(),
            'home_ownerships'=>HomeOwnership::all()->pluck('code','description')->toArray(),
            'regions'=>PhilippineRegion::all()->pluck('region_code','region_description')->toArray(),
            'genders'=>['Male'=>'Male','Female'=>'Female'],
            'provinces' => $provinces,
            'cities' => $cities,
            'barangays' => $barangays,
            'contact' => $lead->contact,
            'fieldsExtracted' => $fieldsExtracted,
            'kwyc_code' => $kwyc_code
        ]);
    }

    public function clienInfoLanding(String $kwyc_code){



        $supplementaryData = collect([
            'agreement' => [
                'term_of_services' => 'By using KwYC Check©, you consent to the following:
                    <ul class="list-decimal ml-6 mt-6">
                        <li>Hyperverge® will capture an image of your ID card, extract data from it, compare it to your selfie, and temporarily store image files for 15 minutes.</li>
                        <li>The system will transmit to Raemulan Lands, Inc.® the raw data, URL links to the images, and, when available, an electronically signed</li>
                    </ul>',
                'privacy_policy' => "<p>Last Updated: August 5, 2024</p>
                    <article>
                        <h2 class=\"font-bold text-black\">1. Introduction</h2>
                        <p>Welcome to MOA Signing and Groundbreaking. We are committed to protecting your personal information and your right to privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you register for our event. Please read this policy carefully. If you do not agree with the terms of this Privacy Policy, please do not register for the event.</p>
                    </article>
                    <article>
                        <h2 class=\"font-bold text-black\">2. Information We Collect</h2>
                        <p>We may collect the following types of information when you register for our event:</p>
                        <ul>
                            <li>Personal Information: Name, email address, phone number, and any other information you provide during registration.</li>
                            <li>Event-Specific Information: Attendance preferences, dietary restrictions, special accommodations, and other relevant details.</li>
                        </ul>
                    </article>
                    <article>
                        <h2 class=\"font-bold text-black\">3. How We Use Your Information</h2>
                        <p>We use the information we collect to:</p>
                        <ul>
                            <li>Process your registration and manage your participation in the event.</li>
                            <li>Communicate with you about the event and related activities.</li>
                            <li>Respond to your inquiries and provide customer support.</li>
                            <li>Improve our event planning and logistics.</li>
                        </ul>
                    </article>
                    <article>
                        <h2 class=\"font-bold text-black\">4. Disclosure of Your Information</h2>
                        <p>We may share your information with:</p>
                        <ul>
                            <li>Event Partners and Sponsors: For event-related purposes, including marketing and promotional activities.</li>
                            <li>Service Providers: To assist with event logistics and operations, such as payment processing and event management.</li>
                            <li>Legal Compliance: If required by law, regulation, or legal process.</li>
                        </ul>
                    </article>
                    <article>
                        <h2 class=\"font-bold text-black\">5. Data Security</h2>
                        <p>We implement appropriate technical and organizational measures to protect your personal information from unauthorized access, disclosure, alteration, or destruction. However, no data transmission over the internet or electronic storage is completely secure, so we cannot guarantee absolute security.</p>
                    </article>
                    <article>
                        <h2 class=\"font-bold text-black\">6. Your Rights</h2>
                        <p>Depending on your jurisdiction, you may have the following rights regarding your personal information:</p>
                        <ul>
                            <li>The right to access, correct, or delete your personal information.</li>
                            <li>The right to object to or restrict the processing of your personal information.</li>
                            <li>The right to data portability.</li>
                        </ul>
                        <p>To exercise these rights, please contact us at [Contact Email].</p>
                    </article>
                    <article>
                        <h2 class=\"font-bold text-black\">7. Changes to This Privacy Policy</h2>
                        <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on our website and updating the \"Last Updated\" date at the top of this policy. Your continued participation in the event after the changes are made will constitute your acceptance of the new policy.</p>
                    </article>
                    <article>
                        <h2 class=\"font-bold text-black\">8. Contact Us</h2>
                        <p>If you have any questions about this Privacy Policy or our data practices, please contact us at:</p>
                        <address>
                            Raemulan Lands Inc. Entrance, 17 ADB Avenue, Topaz Rd, Ortigas Center, Pasig, 1600 Metro Manila
                            <a href=\"mailto:sample@email.com\">sample@email.com</a>
                            <a href=\"tel:+025318788\" class=\"underline\">(02) 5318 7888</a>
                        </address>
                    </article>",
                'term_of_use' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            ],
        ]);
        return Inertia::render('ClientInformationLanding', [
            'supplementaryData' => $supplementaryData,
            'kwyc_code' => $kwyc_code
        ]);
    }

    public function store(Request $request)
    {
        $buyer = $request->input('buyer');
        $spouse = $buyer['spouse'] ?? [];

        $contactData = [
            'reference_code'=> $request->input('kwyc_code'),
            'first_name' => $buyer['first_name'],
            'middle_name' => $buyer['middle_name'] ?? null,
            'last_name' => $buyer['last_name'],
            'name_suffix' => $buyer['name_suffix'] ?? null,
            'civil_status' => $buyer['civil_status'],
            'sex' => $buyer['gender'], // Assuming "gender" maps to "sex"
            'nationality' => $buyer['nationality'],
            'date_of_birth' => $buyer['date_of_birth'],
            'email' => $buyer['email'],
            'mobile' => $buyer['mobile'],
            'spouse' => [
                'first_name' => $spouse['first_name'] ?? null,
                'middle_name' => $spouse['middle_name'] ?? null,
                'last_name' => $spouse['last_name'] ?? null,
                'name_suffix' => $spouse['name_suffix'] ?? null,
                'sex' => $spouse['gender'] ?? null,
                'nationality' => $spouse['nationality'] ?? null,
                'date_of_birth' => $spouse['date_of_birth'] ?? null,
                'email' => $spouse['email'] ?? null,
                'mobile' => $spouse['mobile'] ?? null,
            ],
            'addresses' => [
                [
                    'type' => 'present',
                    'ownership' => $request->input('presentAddress.home_ownership'),
                    'address1' => $request->input('presentAddress.address'),
                    'locality' => $request->input('presentAddress.city'),
                    'administrative_area' => $request->input('presentAddress.province'),
                    'postal_code' => $request->input('presentAddress.zip_code'),
                    'country' => 'PH',
                    'length_of_stay' =>(string) $request->input('presentAddress.years_at_present_address'),
                ],
            ],
        ];

        if ($buyer['civil_status'] == CivilStatus::where('description', 'Married')->first()->code) {
            $contactData['spouse'] = [
                'first_name' => $spouse['first_name'] ?? null,
                'middle_name' => $spouse['middle_name'] ?? null,
                'last_name' => $spouse['last_name'] ?? null,
                'name_suffix' => $spouse['name_suffix'] ?? null,
                'sex' => $spouse['gender'] ?? null,
                'nationality' => $spouse['nationality'] ?? null,
                'date_of_birth' => $spouse['date_of_birth'] ?? null,
                'email' => $spouse['email'] ?? null,
                'mobile' => $spouse['mobile'] ?? null,
            ];
        }

        // if ( $request->input('spousePresentAddress.same_as_permanent_address') !== 'Yes') {
        //     $contactData['addresses'][] = [
        //         'type' => 'spouse_present',
        //         'ownership' => $request->input('spousePresentAddress.home_ownership'),
        //         'address1' => $request->input('spousePresentAddress.address'),
        //         'locality' => $request->input('spousePresentAddress.city'),
        //         'administrative_area' => $request->input('spousePresentAddress.province'),
        //         'postal_code' => $request->input('spousePresentAddress.zip_code'),
        //         'country' => 'PH',
        //         'length_of_stay' => $request->input('spousePresentAddress.years_at_present_address'),
        //     ];
        // }

        try {
            // Now call the PersistContactAction
            $lead = Lead::where('meta->checkin->body->code',$request->input('kwyc_code'))->first();
            // $updated_lead = CreateLeadContactAction::run($lead ,$contactData);
            $contact = PersistContactAction::run($contactData);
            $contact =  Contact::updateOrCreate([
                'reference_code' => $request->input('kwyc_code'),
            ],$contactData);
            $lead->contact=$contact;
            $lead->save();
            // Return response or redirect
            return redirect()->route('payment.choices',['kwyc_code' => $request->input('kwyc_code')]);
        } catch (ValidationException $e) {
            // Handle validation exceptions
            dd($e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle any other exceptions
            return back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
        }
    }
}

