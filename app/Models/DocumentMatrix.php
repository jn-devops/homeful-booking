<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentMatrix extends Model
{
    use HasFactory;
    protected $fillable = [
        'civil_status_code',
        'employment_status_code',
        'market_segment_code',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
    ];

    protected $appends=[
        'documents_descriptions'
    ];

    public function getDocumentsDescriptionsAttribute()
    {
        return Documents::whereIn('code', $this->documents)->pluck('description');
    }


    public function civilStatus(){
        return $this->belongsTo(CivilStatus::class,'civil_status_code','code');
    }

    public function employmentStatus(){
        return $this->belongsTo(EmploymentStatus::class,'employment_status_code','code');
    }

    public function marketSegment(){
        return $this->belongsTo(MarketSegment::class,'market_segment_code','code');
    }


}
