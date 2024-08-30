<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;
use Homeful\Contacts\Models\Contact;

class ContactStatusLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_code',
        'contact_reference_code',
        'updated_by',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_code', 'code');
    }

    public function contacts()
    {
        return $this->belongsTo(Contact::class, 'contact_reference_code', 'reference_code');
    }
}
