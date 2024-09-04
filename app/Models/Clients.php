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
        'tenure'
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

    public function getTenureAttribute()
    {
        return $this->employment[0]['years_in_service'] ?? 0;
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
