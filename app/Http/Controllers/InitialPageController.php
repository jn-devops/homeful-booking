<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Brick\Money\Money;
use Homeful\Borrower\Borrower;
use Homeful\Common\Classes\Input;
use Homeful\Mortgage\Mortgage;
use Homeful\Payment\Class\Term;
use Homeful\Payment\Payment;
use Homeful\Property\Property;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Whitecube\Price\Price;
use function DI\string;
use Homeful\Products\Models\Product;
use Homeful\Mortgage\Data\MortgageData;

class InitialPageController extends Controller
{
    function index(String $sku, String $code = null){

        $product_details = Product::where('sku', $sku)->first();
        $property_details = collect([
            'unit_location' => 'Phase 2 Block 7 Unit 2',
            'regional' => false,
            'price' => 2500000,
            'consulting_fee' => 10000,
            'image' => asset('images/SampleProperty.png'),
        ]);
        $product_details = $product_details??$property_details;

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
            ->setTotalContractPrice(new Price(Money::of($tcp = $property_details['price'], 'PHP')))
            ->setAppraisedValue(new Price(Money::of($tcp, 'PHP')));
        $params = [
            Input::WAGES => 110000,
            Input::TCP => $tcp,
            Input::PERCENT_DP => 5 / 100,
            Input::DP_TERM => 12,
            Input::BP_INTEREST_RATE => 7 / 100,
            Input::PERCENT_MF => 8.5 / 100,
            Input::LOW_CASH_OUT => 0.0,
            Input::BP_TERM => 20,
            Input::DOWN_PAYMENT => 100000,

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
            'productDetails' => $product_details
        ]);
    }
}

