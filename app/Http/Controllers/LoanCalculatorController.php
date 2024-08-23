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
        return redirect()->route('dashboard');
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
