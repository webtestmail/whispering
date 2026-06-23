<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'position_order',
        'header_footer_name',
        'service_title',
        'service_name',
        'service_url',
        'short_description',
        'service_icon',
        'button_name',
        'description',
        'service_highlights',
        'service_image',
        'breadcrumb_headline',
        'breadcrumb_description',
        'breadcrumb_image',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'visibility',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'position_order' => 'integer',
        'header_footer_name' => 'string',
        'service_title' => 'string',
        'service_name' => 'string',
        'service_url' => 'string',
        'short_description' => 'string',
        'service_icon' => 'string',
        'button_name' => 'string',
        'description' => 'string',
        'service_highlights' => 'string',
        'service_image' => 'string',
        'breadcrumb_headline' => 'string',
        'breadcrumb_description' => 'string',
        'breadcrumb_image' => 'string',
        'meta_title' => 'string',
        'meta_keyword' => 'string',
        'meta_description' => 'string',
        'visibility' => 'string',
        'status' => 'string',
    ];
}
