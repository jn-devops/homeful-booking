<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use Illuminate\Http\Request;

class KWYCController extends Controller
{
    function index(){
        return Inertia::render('VerifyIdentity');
    }
}
