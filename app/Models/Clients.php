<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Homeful\Contacts\Models\Contact;
class Clients extends Contact
{
    use HasFactory;
    protected $table = 'contacts';
    // Declare only the additional fields
    protected $additionalFillable = [
        'current_status',
        'current_status_code',
    ];
    protected $appends = [
        'full_name',
        'tenure',
        'age',
        'present_address',
        'same_as_permanent_address',
        'buyer_employment',
    ];


    public function __construct(array $attributes = [])
    {
        // Merge the parent's fillable array with the new fields
        $this->fillable = array_merge($this->getFillable(), $this->additionalFillable);
        parent::__construct($attributes);
    }

    public function getFullNameAttribute()
    {
        return trim(($this->first_name?? '') . ' ' . ($this->middle_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    public function getSameAsPermanentAddressAttribute(): bool
    {
        // Get the present address
        $presentAddress = collect($this->toData()['addresses'])->firstWhere('type', 'Present');

        // Get the permanent address
        $permanentAddress = collect($this->toData()['addresses'])->firstWhere('type', 'Permanent');

        // If either address is not set, they are not the same
        if (!$presentAddress || !$permanentAddress) {
            return false;
        }
        // Compare the two addresses to see if they are the same
        return $presentAddress == $permanentAddress;
    }

    public function getBuyerEmploymentAttribute(): array{
        $employment = collect($this->toData()['employment'])->firstWhere('type', 'buyer');
        return $employment;
    }

    public function getPresentAddressAttribute(): array
    {
        // Default structure for the "Present" address with empty values
        $defaultAddress = [
            'type' => '',
            'ownership' => '',
            'full_address' => '',
            'address1' => '',
            'address2' => '',
            'sublocality' => '',
            'locality' => '',
            'administrative_area' => '',
            'postal_code' => '',
            'sorting_code' => '',
            'country' => '',
            'block' => '',
            'lot' => '',
            'unit' => '',
            'floor' => '',
            'street' => '',
            'building' => '',
            'length_of_stay' => ''
        ];
        // dd($this->toData()['addresses']);

        $presentAddress = collect($this->toData()['addresses'])->firstWhere('type', 'Present');

        return array_merge($defaultAddress, $presentAddress ?? []);
    }

    public function getTenureAttribute()
    {
        return $this->employment[0]['years_in_service'] ?? 0;
    }

    public function getAgeAttribute()
    {
        // dd($this->date_of_birth
        // ? \Carbon\Carbon::parse($this->date_of_birth)->diffInYears(now())
        // : 0);
        return $this->date_of_birth
        ? \Carbon\Carbon::parse($this->date_of_birth)->diffInYears(now())
        : 0;
    }


    public function status()
    {
        return $this->belongsTo(Status::class, 'current_status_code', 'code');
    }

    public function statusLogs()
    {
        return $this->hasMany(ContactStatusLogs::class, 'reference_code', 'contact_reference_code');
    }
}
