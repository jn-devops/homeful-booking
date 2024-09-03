<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InitialPageController extends Controller
{
    function index(String $sku, String $code = null){

        return Inertia::render('InitialPage', [
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg'),
        ]);
    }
}
