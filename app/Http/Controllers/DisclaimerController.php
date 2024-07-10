<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisclaimerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia()->render('Consult/Disclaimer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $agree = (bool) $request->get('agree');
        $request->session()->put(key: 'disclaimer-agree', value: $agree);

        return $agree ? redirect()->intended() : redirect(route('dashboard'));
    }
}
