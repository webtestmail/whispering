<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    use HasFactory;

    protected $table = 'testimonials';

    protected $fillable = [
        'position_order',
        'rating_quantity',
        'client_name',
        'client_designation',
        'description',
        'client_image',
        'status',
        'company_name'
    ];

    protected $casts = [
        'id' => 'integer',
        'position_order' => 'integer',

    ];
}
