<?php

namespace App\Http\Controllers;

use App\Models\CivilStatus;
use Homeful\Common\Classes\Input;
use Homeful\Common\Classes\Input as InputFieldName;
use Homeful\Contacts\Actions\PersistContactAction;
use Homeful\Contacts\Models\Contact;
use Homeful\Contracts\Models\Contract;
use Homeful\Contracts\States\Availed;
use Homeful\Contracts\States\Consulted;
use Homeful\Contracts\States\Onboarded;
use Homeful\KwYCCheck\Actions\CreateLeadContactAction;
use Homeful\KwYCCheck\Models\Lead;
use Homeful\Mortgage\Data\MortgageData;
use Homeful\Mortgage\Mortgage;
use Homeful\Paymate\Paymate;
use Homeful\Products\Models\Product;
use Homeful\Property\Property;
use Homeful\References\Actions\CreateReferenceAction;
use Homeful\References\Models\Reference;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class BookingController extends Controller
{
    function index(String $sku, String $code = null){

        // return 404 if sku not found
        $product_details = Product::where('sku', $sku)->firstOrFail();
        $property_details = \Homeful\Properties\Models\Property::where('sku', $sku)->firstOrFail();

        $contract = new Contract();
        $contract->inventory = $property_details;
        $contract->seller_commission_code = $code;
        $contract->save();


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
            'welcome_agreement' => [
                'term_of_services' => '
                    <p class="mb-3">Home buying is a long term purchase that requires a long term commitment in the form of a dedicated fund.  Therefore, buying a home is a significant decision with long-term implications, making it crucial to carefully consider several factors before committing.</p>

                    <p class="mb-3">Our Home Loan Consultation helps you understand your options, determine the best home solutions for your situation and guide you through the Home Loan Consultation process.</p>

                    <p class="mb-3">This specialized service comes with a Consultation Fee that reflects the value of receiving expert guidance tailored to your specific needs.</p>

                    <p class="mb-3">The Consultation Fee is non-refundable as this compensates time and expertise in evaluating and guiding you thru your buying decision process.</p>

                    <p class="mb-3">Should you decide to proceed after the evaluation, the Consultation Fee can be converted as your Processing Fee, which will be used to officially reserve the unit under your name.</p>
                ',
            ],
            'consulting_content_link' => asset('test.pdf'),
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg')
        ]);

        $calculator = [];
        $property = (new Property)
            ->setTotalContractPrice($product_details->price)
            ->setAppraisedValue($product_details->price);
        $params = [
            Input::WAGES => 110000,
            Input::TCP => $product_details->price->inclusive()->getAmount()->toFloat(),
            Input::PERCENT_DP => 5 / 100,
            Input::DP_TERM => 12,
            Input::BP_INTEREST_RATE => 7 / 100,
            Input::PERCENT_MF => 8.5 / 100,
            Input::LOW_CASH_OUT => 0.0,
            Input::BP_TERM => 20,
        ];
        $mortgage = Mortgage::createWithTypicalBorrower($property, $params);
        $data = MortgageData::fromObject($mortgage);

        $calculator = [
            'guess_down_payment_amount' => $data->down_payment,
            'guess_dp_amortization_amount' => $data->dp_amortization,
            'guess_partial_miscellaneous_fees' => $data->partial_miscellaneous_fees,
            'guess_miscellaneous_fees' => $data->miscellaneous_fees,
            'guess_balance_payment' => $data->loan_amount,
            'age' => $data->borrower->age,
            'guess_gross_monthly_income' => $data->borrower->gross_monthly_income,
            'down_payment_term' => $data->dp_term,
            'balance_payment_term' => $data->bp_term,
            'percent_down_payment' => $data->percent_down_payment,
            'regional' =>  $data->borrower->regional,
            'total_contract_price' => $data->property->total_contract_price,
            'percent_miscellaneous_fees' => $data->percent_mf,
            'guess_monthly_amortization' => $data->loan_amortization,
        ];

        return Inertia::render('InitialPage', [
            'supplementaryData' => $supplementaryData,
            'calculator' => $calculator,
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg'),
            'propertyDetail' => $property_details,
            'sku'=>$sku,
            'code'=>$code,
            'productDetails' => $product_details,
            'contract'=>$contract,
            'property_image'=> json_decode($product_details->facade_url)->facade,
        ]);
    }

    function consulted($contract)
    {
        $contract->state->transitionTo(Consulted::class, reference: new Reference());
    }

    function availed($contract_id,Request $request)
    {
        $contract= Contract::where('id',$contract_id)->firstOrFail();
        $action = app(CreateReferenceAction::class);
        $calculator = json_decode($request->input('calculator'), true);
        $attribs = array_merge($calculator, [
            'seller_commission_code' => $contract->seller_commission_code,
            InputFieldName::BP_INTEREST_RATE =>config('mortgage.default_interest_rate'),
            'sku'=> $contract->inventory->sku,
            'wages'=>110000,
            'promo_code'=>''
        ]);

        try {
            $action = app(CreateReferenceAction::class);
            $reference = $action->run($attribs,[]);

            $contract->state->transitionTo(Availed::class, reference:  $reference);
        }catch (Exception $e){
            Log::error('Error creating reference:', ['error' => $e->getMessage()]);
        }
        return redirect()->route('proceed', ['reference_code' => $reference->code]);
    }

    function proceed(String $contract_id,String $reference_code){

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
            'consulting_content_link' => asset('test.pdf'),
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg')
        ]);

        return Inertia::render('Proceed', [
            'supplementaryData' => $supplementaryData,
            'reference_code'=>$reference_code,
            'contract_id'=>$contract_id,
        ]);
    }

    function kwyc_sign_up(String $contract_id,String $reference_code){
        $contract=Contract::where('id',$contract_id)->firstOrFail();
        $reference=Reference::where('code',$reference_code)->firstOrFail();
        return Inertia::render('KWYCSignup',[
            'reference'=>$reference,
            'contract'=> $contract
        ]);
    }

    function kwyc(String $contract_id,String $reference_code,Request $request){
        $contract=Contract::where('id',$contract_id)->firstOrFail();
        $reference=Reference::where('code',$reference_code)->firstOrFail();
        $campaignUrl = config('kwyc-check.campaign_url');
        $urlParams = http_build_query([
            'identifier' => $reference->code,
            'contract_id'=>$contract->id,
            'choice' =>$contract->inventory->sku,
            'code' => $contract->seller_commission_code,
            'email'=>$request->email,
            'mobile'=>$request->mobile
        ]);

        $fullUrl = "{$campaignUrl}?{$urlParams}";
        $supplementaryData = collect([
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg')
        ]);
        return Inertia::render('VerifyIdentity', [
            'reference_code' => $reference->code ,
            'contract_id'=>$contract_id,
            'url' => $fullUrl ,
            'supplementaryData' => $supplementaryData,
        ]);
    }

    function verified(String $contract_id,String $reference_code){
        $contract=Contract::where('id',$contract_id)->firstOrFail();
        $reference=Reference::where('code',$reference_code)->firstOrFail();
        $contract->state->transitionTo(Verified::class, reference:$reference);
    }



    public function clienInfoLanding(String $contract_id,String $reference_code){

        $supplementaryData = collect([
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg'),
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
            'contract_id' => $contract_id,
            'reference_code'=>$reference_code
        ]);
    }

    public function clienInfoStore(String $contract_id,String $reference_code){
        $contract=Contract::where('id',$contract_id)->firstOrFail();
        $reference=Reference::where('code',$reference_code)->firstOrFail();
        $contactData = [
            'reference_code' => $request->input('kwyc_code'),
            'first_name' =>  $request->input('first_name'),
            'middle_name' =>  $request->input('middle_name') ?? null,
            'last_name' =>  $request->input('last_name'),
            'name_suffix' =>  $request->input('name_suffix') ?? null,
            'civil_status' =>  $request->input('civil_status'),
            'sex' =>  $request->input('gender'),
            'nationality' =>  $request->input('nationality')?? 'Filipino',
            'date_of_birth' =>  $request->input('date_of_birth'),
            'email' =>  $request->input('email'),
            'mobile' =>  $request->input('mobile'),
            'addresses' => [
                [
                    'type' => 'present',
                    'ownership' => $request->input('present_address_home_ownership'),
                    'address1' => $request->input('present_address_address'),
                    'locality' => $request->input('present_address_city'),
                    'administrative_area' => $request->input('present_address_province'),
                    'postal_code' => $request->input('present_address_zip_code'),
                    'country' => 'PH',
                    'length_of_stay' =>(string) $request->input('present_address_years_at_present_address'),
                ],

            ],
            'employment' => [
                [
                    'type' => 'buyer',
                    'employment_status' => $request->input('employment_status'),
                    'monthly_gross_income' => $request->input('gross_monthly_income'),
                    'current_position' => $request->input('current_position'),
                    'employment_type' => $request->input('employment_type'),
                    'years_in_service' => $request->input('tenure'),
                    'industry' => $request->input('work_industry'),
                    'rank' => $request->input('rank'), // No equivalent field to contact
                    'id' => [
                        'pagibig' => $request->input('pagibig_no'),
                        'sss' => $request->input('sss_gsis_no'),
                        'gsis' => $request->input('sss_gsis_no'),
                    ],
                    'tax_identification_no' => $request->input('tax_identification_no'),
                    'pagibig_no' => $request->input('pagibig_no'),
                    'sss_gsis_no' => $request->input('sss_gsis_no'),
                    'employer_name' => $request->input('employer_details_employer_name'),
                    'years_of_operation' => $request->input('employer_details_years_of_operation'),
                    'contact_person' => $request->input('employer_details_contact_person'),
                    'email' => $request->input('employer_details_email'),
                    'contact_no' => $request->input('employer_details_contact_no'),
                    'country' => $request->input('employer_details_country'),
                    'employer_complete_address' => $request->input('employer_details_employer_complete_address'),
                ]
            ],
        ];

        if ($contactData['civil_status'] == CivilStatus::where('description', 'Married')->first()->code) {
            $contactData['spouse'] =[
                'first_name' => $request->input('spouse_first_name') ?? null,
                'middle_name' => $request->input('spouse_middle_name') ?? null,
                'last_name' => $request->input('spouse_last_name') ?? null,
                'name_suffix' => $request->input('spouse_name_suffix') ?? null,
                'sex' => $request->input('spouse_gender') ?? null,
                'nationality' => $request->input('spouse_nationality') ?? 'Filipino',
                'date_of_birth' => $request->input('spouse_date_of_birth') ?? null,
                'email' => $request->input('spouse_email') ?? null,
                'mobile' => $request->input('spouse_mobile') ?? null,
            ];
            $contactData['addresses'] =
                [
                    [
                        'type' => 'present',
                        'ownership' => $request->input('present_address_home_ownership'),
                        'address1' => $request->input('present_address_address'),
                        'locality' => $request->input('present_address_city'),
                        'administrative_area' => $request->input('present_address_province'),
                        'postal_code' => $request->input('present_address_zip_code'),
                        'country' => 'PH',
                        'length_of_stay' =>(string) $request->input('present_address_years_at_present_address'),
                    ],[
                    'type' => 'spouse',
                    'ownership' => $request->input('spouse_present_address_home_ownership'),
                    'address1' => $request->input('spouse_present_address_address'),
                    'locality' => $request->input('spouse_present_address_city'),
                    'administrative_area' => $request->input('spouse_present_address_province'),
                    'postal_code' => $request->input('spouse_present_address_zip_code'),
                    'country' => 'PH',
                    'length_of_stay' =>(string) $request->input('spouse_present_address_years_at_present_address'),
                ],
                ];
        }

        // dd($contactData);

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
//            $lead = Lead::where('meta->checkin->body->code',$request->input('kwyc_code'))->first();
//            $updated_lead = CreateLeadContactAction::run($lead ,$contactData);
            // $contact = PersistContactAction::run($contactData);
            // $contact =  Contact::updateOrCreate([
            //     'reference_code' => $request->input('kwyc_code'),
            // ],$contactData);
            // $lead->contact=$contact;
            // $lead->save();
            // dd($updated_lead,$contactData,$request->all());

            // Return response or redirect
            $contract->customer = PersistContactAction::run($contactData);
            $this->onboarded($contract_id,$reference_code);
            return redirect()->route('payment.choices',['kwyc_code' => $request->input('kwyc_code')]);
        } catch (ValidationException $e) {
            dd($e);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
        }
    }

    function onboarded(String $contract_id,String $reference_code){
        $contract=Contract::where('id',$contract_id)->firstOrFail();
        $reference=Reference::where('code',$reference_code)->firstOrFail();
        $contract->state->transitionTo(Onboarded::class, reference:$reference);
    }

    function payment_choices(String $contract_id,String $reference_code)
    {
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
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg')
        ]);
        return Inertia::render('PaymentChoices', [
            'supplementaryData' => $supplementaryData,
            'contract_id'=>$contract_id,
            'reference_code'=>$reference_code,
        ]);
    }

    function credit_debit_card_payment(String $contract_id,String $reference_code){
        return Inertia::render('CreditDebitCardPayment',[
            'contract_id'=>$contract_id,
            'reference_code'=>$reference_code,
        ]);
    }

    function cardPayment(String $contract_id,String $reference_code, Request $request){

        $contract=Contract::where('id',$contract_id)->firstOrFail();
        $reference=Reference::where('code',$reference_code)->firstOrFail();

        $paymate = new Paymate();
        $cardData = $request->all();
        $jsonInput = [
//            "buyerName" => $lead->meta['checkin']['body']['data']['fieldsExtracted']['fullName'],
//            "email" => $lead->meta['checkin']['body']['inputs']['email'],
            "expirationMonth" => substr($cardData['expirationDate'], 0, 2),
            "expirationYear" => '20' . substr($cardData['expirationDate'], 3, 2),
            "securityCode" => $cardData['cvv'],
            "pan" => str_replace('-', '', $cardData['cardNumber']),
            "referenceCode" => $reference_code,
            "amount" => "100"
        ];
        $response = $paymate->payment_online(new Request($jsonInput));

        dd($response);
    }

    function qrPayment(String $contract_id,String $reference_code){
        $paymate = new Paymate();
        $jsonInput = [
            "referenceCode" => $reference_code, // alpha-numeric
            "amount" => "100" // integer include two decimal w/o '.' ; Ex. 100 = 1.00
        ];
        $response = $paymate->payment_qrph(new Request($jsonInput));

        // dd($response);
        return response()->json($response['code_url']);
    }

    function digitalWalletPayment(String $contract_id,String $reference_code,Request $request){
        $paymate = new Paymate();
        $jsonInput = [
            "wallet" => $request->wallet, // gcash or grabpay
            "referenceCode" => $reference_code, // alpha-numeric
            "amount" => "100" // integer include two decimal w/o '.' ; Ex. 100 = 1.00
        ];
        $response = $paymate->payment_wallet(new Request($jsonInput));
        // dd($response['pay_url']);
        return response()->json($response['pay_url']);
    }

    function paid(Request $requestq){

    }
}