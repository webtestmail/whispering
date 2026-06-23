<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'position_order',
        'brand_name',
        'brand_image',
        'status'
    ];

    protected $casts = [
        'id' => 'integer',
        'position_order' => 'integer',
        'brand_name' => 'string',
        'status' => 'string',
    ];
}
