<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Homeful\Contacts\Models\Contact;
class Clients extends Contact
{
    use HasFactory;
    protected $fillable = [
        ...parent::$fillable, // Retain all original fields
        'current_status',
        'current_status_code',
    ];


    public function status()
    {
        return $this->belongsTo(Status::class, 'current_status_code', 'code');
    }

    public function statusLogs()
    {
        return $this->hasMany(ContactStatusLogs::class, 'reference_code', 'contact_reference_code');
    }
}
