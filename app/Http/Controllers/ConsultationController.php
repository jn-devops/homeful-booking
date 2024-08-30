<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class ConsultationController extends Controller
{
    public function entryPoint(String $sku, String $code = null)
    {

        return redirect()->route('proceed',[$sku, $code]);
    }
}
