<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class GetQualifiedController extends Controller
{
    function index(){
        return Inertia::render('GetQualified');
    }
}
