<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InitialPageController extends Controller
{
    function index(String $sku, String $code = null){

        $supplementaryData = collect([
            'agreement' => [
                'term_of_services' => '
                    <p class="mb-3">Home buying is a long term purchase that requires a long term commitment in the form of a dedicated fund.  Therefore, buying a home is a significant decision with long-term implications, making it crucial to carefully consider several factors before committing.</p>

                    <p class="mb-3">Our Home Loan Consultation helps you understand your options, determine the best home solutions for your situation and guide you through the Home Loan Consultation process.</p> 

                    <p class="mb-3">This specialized service comes with a Consultation Fee that reflects the value of receiving expert guidance tailored to your specific needs.</p>

                    <p class="mb-3">The Consultation Fee is non-refundable as this compensates time and expertise in evaluating and guiding you thru your buying decision process.</p>

                    <p class="mb-3">Should you decide to proceed after the evaluation, the Consultation Fee can be converted as your Processing Fee, which will be used to officially reserve the unit under your name.</p>
                ',
            ]
        ]);
        return Inertia::render('InitialPage', [
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg'),
            'supplementaryData' => $supplementaryData,
        ]);
    }
}
