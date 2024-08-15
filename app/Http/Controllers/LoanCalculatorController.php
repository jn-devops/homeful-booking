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
            Input::PERCENT_DP => (int) $request['percent_down_payment'],
            Input::BP_INTEREST_RATE => 6.25 / 100, // Todo: where to get the interest rate
            Input::BP_TERM => (int) $request['balance_payment_term'],
            Input::PERCENT_MF => (int) $request['percent_miscellaneous_fees'],
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
            'guess_gross_monthly_income' => (int)((String)$mortgage->getBorrower()->getGrossMonthlyIncome()->base()->getAmount()),
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
}
