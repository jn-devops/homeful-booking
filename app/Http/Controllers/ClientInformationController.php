<?php

namespace App\Http\Controllers;

use App\Models\CivilStatus;
use App\Models\NameSuffix;
use App\Models\Nationality;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientInformationController extends Controller
{
    public function show()
    {
        $provinces = PhilippineProvince::all()->map(function($province) {
            return [
                'region_code' => $province->region_code,
                'province_code' => $province->province_code,
                'province_description' => $province->province_description,
            ];
        })->toArray();

        $cities = PhilippineCity::all()->map(function($city) {
            return [
                'province_code' => $city->province_code,
                'city_municipality_code' => $city->city_municipality_code,
                'city_municipality_description' => $city->city_municipality_description,
            ];
        })->toArray();

        $barangays = PhilippineBarangay::all()->map(function($barangay) {
            return [
                'city_municipality_code' => $barangay->city_municipality_code,
                'barangay_code' => $barangay->barangay_code,
                'barangay_description' => $barangay->barangay_description,
            ];
        })->toArray();

        return Inertia::render('ClientInformation', [
            'name_suffixes'=>NameSuffix::all()->pluck('code','description')->toArray(),
            'nationalities'=>Nationality::all()->pluck('code','description')->toArray(),
            'civil_statuses'=>CivilStatus::all()->pluck('code','description')->toArray(),
            'regions'=>PhilippineRegion::all()->pluck('region_code','region_description')->toArray(),
            'genders'=>['Male'=>'Male','Female'=>'Female'],
            'provinces' => $provinces,
            'cities' => $cities,
            'barangays' => $barangays,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'address.present.city' => 'required|string|max:255',
        ]);

        if($validated){
            dd($validated);
        }

        return redirect()->back()->with('success', 'Form submitted successfully.');
    }
}
