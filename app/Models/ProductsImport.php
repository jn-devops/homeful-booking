<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsImport extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'project_location',
        'project_code',
        'property_name',
        'phase',
        'block',
        'lot',
        'lot_area',
        'floor_area',
        'project_address',
        'property_type',
        'unit_type',
        'unit_type_interior',
        'house_color',
        'building',
        'processing_fee',
        'brand',
        'sku',
        'name',
        'price',
        'market_segment',
        'category',
        'description',
        'product_location_details',
        'lifestyle_destinations',
        'amenities',
        'how_to_get_there',
        'appraised_value',
    ];
}
