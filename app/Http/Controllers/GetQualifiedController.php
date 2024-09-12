<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class GetQualifiedController extends Controller
{
    function index(){

        $supplementaryData = collect([
            'homefulBookingUrl' => asset('images/HomefulBookingIcon.jpeg')
        ]);

        return Inertia::render('GetQualified', [
            'supplementaryData' => $supplementaryData,
        ]);
    }
}
