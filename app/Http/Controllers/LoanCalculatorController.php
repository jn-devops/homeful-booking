<?php

namespace App\Http\Controllers;

use Brick\Money\Money;
use Homeful\Borrower\Borrower;
use Homeful\Common\Classes\Input;
use Homeful\Mortgage\Mortgage;
use Homeful\Payment\Class\Term;
use Homeful\Payment\Payment;
use Homeful\Property\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

use Inertia\Inertia;
use Whitecube\Price\Price;
use function DI\string;

class LoanCalculatorController extends Controller
{
    function dashboard(){
        $property_details = collect([
            'unit_location' => 'Phase 2 Block 7 Unit 2',
            'regional' => false,
            'price' => 2500000,
        ]);

        $supplementaryData = collect([
            'agreement' => [
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

        with(Mortgage::createWithTypicalBorrower($property, $params), function (Mortgage $mortgage) use ($params, &$calculator, $property_details) {

            $calculator = [
                'guess_down_payment_amount' => (int)((string)$mortgage->getDownPayment()->getPrincipal()->inclusive()->getAmount()),
                'guess_dp_amortization_amount' => (int)((string)$mortgage->getDownPayment()->getMonthlyAmortization()->inclusive()->getAmount()),
                'guess_partial_miscellaneous_fees' => (int)((string)$mortgage->getPartialMiscellaneousFees()->inclusive()->getAmount()),
                'guess_balance_payment' => (int)((string)$mortgage->getLoan()->getPrincipal()->inclusive()->getAmount()),
                'age' => $mortgage->getDefaultAge(),
                'guess_gross_monthly_income' => (int)((String)$mortgage->getBorrower()->getGrossMonthlyIncome()->base()->getAmount()),
                'down_payment_term' => $mortgage->getDownPayment()->getTerm()->monthsToPay(),
                'balance_payment_term' => $mortgage->getBalancepaymentTerm(),
                'percent_down_payment' => $mortgage->getPercentDownPayment(),
                'regional' =>  $property_details['regional'],
                'total_contract_price' => $property_details['price'],
                'percent_miscellaneous_fees' => $mortgage->getPercentMiscellaneousFees(),
            ];
            $year_term = $mortgage->getDownPayment()->getTerm()->monthsToPay();
            with($mortgage->getLoan()->setTerm(new Term($year_term)), function (Payment $loan) use(&$calculator) {
                $calculator['guess_monthly_amortization'] = (int)((string)$loan->getMonthlyAmortization()->inclusive()->getAmount());
            });

        });

        return Inertia::render('Dashboard', [
            'calculator' => $calculator,
            'property_details' => $property_details,
            'supplementaryData' => $supplementaryData,
        ]);
    }

    function calculate_loan(Request $request){

        $validated = Validator::make($request->all(), [
            'age' => ['required'],
            'regional' => ['required'],
            'gross_monthly_income' => ['required'],
            'total_contract_price' => ['required'],
            'appraised_value' => ['required'],
            'percent_down_payment' => ['required'],
            'balance_payment_term' => ['required'],
            'percent_miscellaneous_fees' => ['required'],
        ])->validate();

        $borrower = (new Borrower)
            ->setRegional($request['regional'])
            ->setAge($request['age'])
            ->setGrossMonthlyIncome($request['gross_monthly_income']);

        $property = (new Property)
            ->setTotalContractPrice(new Price(Money::of($request['total_contract_price'], 'PHP')))
            ->setAppraisedValue(new Price(Money::of($request['appraised_value'], 'PHP')));

        $params = [
            Input::PERCENT_DP => $request['percent_down_payment'],
            Input::BP_INTEREST_RATE => 6.25 / 100, // Todo: where to get the interest rate
            Input::BP_TERM => $request['balance_payment_term'],
            Input::PERCENT_MF => $request['percent_miscellaneous_fees'],
            Input::TCP => $request['total_contract_price'],
            Input::DP_TERM => 12,
            Input::CONSULTING_FEE => 10000,
        ];

        $mortgage = new Mortgage(property: $property, borrower: $borrower, params: $params);
//        dd( $mortgage->getDownPayment()->getPrincipal()->inclusive()->getAmount());

        $mortage_data = [
            'guess_down_payment_amount' => (int)((string)$mortgage->getDownPayment()->getPrincipal()->inclusive()->getAmount()),
            'guess_dp_amortization_amount' => (int)((string)$mortgage->getDownPayment()->getMonthlyAmortization()->inclusive()->getAmount()),
            'guess_partial_miscellaneous_fees' => (int)((string)$mortgage->getPartialMiscellaneousFees()->inclusive()->getAmount()),
            'guess_balance_payment' => (int)((string)$mortgage->getLoan()->getPrincipal()->inclusive()->getAmount()),
            'age' => round($mortgage->getBorrower()->getBirthdate()->diffInYears(Carbon::now())),
            'gross_monthly_income' => (int)((String)$mortgage->getBorrower()->getGrossMonthlyIncome()->base()->getAmount()),
            'down_payment_term' => $mortgage->getDownPayment()->getTerm()->monthsToPay(),
            'balance_payment_term' => $mortgage->getBalancepaymentTerm(),
            'percent_down_payment' => $mortgage->getPercentDownPayment(),
            'regional' => $request['regional'],
            'gross_monthly_income' => (int)((String)$mortgage->getBorrower()->getGrossMonthlyIncome()->base()->getAmount()),
            'total_contract_price' => $request['total_contract_price'],
            'percent_miscellaneous_fees' => $mortgage->getPercentMiscellaneousFees(),
        ];

        $year_term = $mortgage->getDownPayment()->getTerm()->monthsToPay();
        with($mortgage->getLoan()->setTerm(new Term($year_term)), function (Payment $loan) use(&$mortage_data) {
            $mortage_data['guess_monthly_amortization'] = (int)((string)$loan->getMonthlyAmortization()->inclusive()->getAmount());
        });

        $data = collect($mortage_data);
//        dd($data);

        return back()->with('event', [
            'name' => 'loan.calculated',
            'data' => $data,
        ]);

    }

    function test(){
        $params = [
            Input::TCP => 2500000,
            Input::PERCENT_DP => 5 / 100,
            Input::PERCENT_MF => 8.5 / 100,
            Input::DP_TERM => 12,
            Input::BP_TERM => 20,
            Input::BP_INTEREST_RATE => 7 / 100,
        ];
        $borrower = (new Borrower)
            ->setRegional(false)
            ->setAge(40)
            ->setGrossMonthlyIncome(57080);
        $property = (new Property)
            ->setTotalContractPrice(new Price(Money::of($tcp = 2500000, 'PHP')))
            ->setAppraisedValue(new Price(Money::of($tcp, 'PHP')));
        $mortgage = new Mortgage(property: $property, borrower: $borrower, params: $params);

        $year_term = $mortgage->getDownPayment()->getTerm()->monthsToPay();
        $guess_monthly_amortization = 0;
        with($mortgage->getLoan()->setTerm(new Term($year_term)), function (Payment $loan) use(&$guess_monthly_amortization) {
            $guess_monthly_amortization = (int)((string)$loan->getMonthlyAmortization()->inclusive()->getAmount());
        });
        dd(
            (int)((string)$mortgage->getDownPayment()->getPrincipal()->inclusive()->getAmount()),
            (int)((string)$mortgage->getDownPayment()->getMonthlyAmortization()->inclusive()->getAmount()),
            (int)((String)$mortgage->getBorrower()->getGrossMonthlyIncome()->base()->getAmount()),
            (int)((string)$mortgage->getPartialMiscellaneousFees()->inclusive()->getAmount()),
            (int)((string)$mortgage->getLoan()->getPrincipal()->inclusive()->getAmount()),
            $mortgage->getBalancepaymentTerm(),
            $guess_monthly_amortization
        );
    }
}
