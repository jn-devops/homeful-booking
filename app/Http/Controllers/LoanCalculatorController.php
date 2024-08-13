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
use Inertia\Inertia;
use Whitecube\Price\Price;

class LoanCalculatorController extends Controller
{
    function dashboard(){
        $property_details = collect([
            'unit_location' => 'Phase 2 Block 7 Unit 2',
            'regional' => false,
            'price' => 2500000,
        ]);

        $calculator = [];

        $property = (new Property)
            ->setTotalContractPrice(new Price(Money::of($tcp = $property_details['price'], 'PHP')))
            ->setAppraisedValue(new Price(Money::of($tcp, 'PHP')));
        $borrower = (new Borrower)
            ->setRegional(false)
            ->setGrossMonthlyIncome(50000);
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

        with(Mortgage::createWithTypicalBorrower($property, $params), function (Mortgage $mortgage) use ($params, &$calculator) {

            $calculator = [
                'guess_down_payment_amount' => $mortgage->getDownPayment()->getPrincipal()->inclusive()->formatTo('en-PH'),
                'guess_dp_amortization_amount' => $mortgage->getDownPayment()->getMonthlyAmortization()->inclusive()->formatTo('en-PH'),
                'guess_partial_miscellaneous_fees' => $mortgage->getPartialMiscellaneousFees()->inclusive()->formatTo('en-PH'),
                'guess_balance_payment' => $mortgage->getLoan()->getPrincipal()->inclusive()->formatTo('en-PH'),
                'age' => $mortgage->getDefaultAge(),
                'guess_gross_monthly_income' => (int)((String)$mortgage->getBorrower()->getGrossMonthlyIncome()->base()->getAmount()),
                'down_payment_term' => $mortgage->getDownPayment()->getTerm()->monthsToPay(),
                'loan_term' => $mortgage->getLoan()->getTerm()->yearsToPay(),
                'percent_down_payment' => ($mortgage->getPercentDownPayment() * 100),
                'balance_down_payment' => ($mortgage->getPercentDownPayment() * 100) - 100,
            ];

            $year_term = $mortgage->getDownPayment()->getTerm()->monthsToPay();

            with($mortgage->getLoan()->setTerm(new Term($year_term)), function (Payment $loan) use(&$calculator) {
                $calculator['guess_monthly_amortization'] = $loan->getMonthlyAmortization()->inclusive()->formatTo('en-PH');
            });

//            dd($mortgage->getLoan()->getTerm()->yearsToPay());
        });

        return Inertia::render('Dashboard', [
            'calculator' => $calculator,
            'property_details' => $property_details,
        ]);
    }
}
