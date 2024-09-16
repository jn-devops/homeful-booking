<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Homeful\References\Actions\CreateReferenceAction;
use Homeful\Common\Classes\Input as InputFieldName;
use Exception;
use Log;
class KWYCController extends Controller
{
    function index(String $sku, String $code = null, Request $request){

        $supplementaryData = collect([
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg')
        ]);
       $calculator = json_decode($request->input('calculator'), true);

       $attribs = array_merge($calculator, [
           'seller_commission_code' => $code,
           InputFieldName::BP_INTEREST_RATE =>config('mortgage.default_interest_rate'),
       ]);


       try {
            // Attempt to execute the action
            $action = app(CreateReferenceAction::class);
            $references = $action->run($attribs,[]);
            $campaignUrl = config('kwyc-check.campaign_url');
            $urlParams = http_build_query([
                'identifier' => $references->code,
                'choice' => $sku,
                'code' => $code
            ]);

            $fullUrl = "{$campaignUrl}?{$urlParams}";
            return Inertia::render('VerifyIdentity', [
                'sku' => $sku,
                'code' => $code,
                'calculator' => $request->input('calculator'),
                'reference_code' => $references->code ?? '',
                'url' => $fullUrl ,
                'supplementaryData' => $supplementaryData,

            ]);
        } catch (Exception $e) {

            Log::error('Error creating reference:', ['error' => $e->getMessage()]);

            // return redirect()->back()->withErrors(['error' => 'There was an issue processing your request. Please try again later.']);
        }
    }

    function sign_up(){
        return Inertia::render('KWYCSignup');

    }
}
