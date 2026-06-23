<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $table = 'pages';

    protected $fillable = [
        'position_order',
        'header_footer_name',
        'client_page_urls',
        'visibility',
        'page_name',
        'page_headline',
        'breadcrumb_headline',
        'page_image',
        'breadcrumb_description',
        'description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status',
        'video_link'
    ];

    protected $casts = [
        'id' => 'integer',
        'position_order' => 'integer',
        'header_footer_name' => 'string',
        'client_page_urls' => 'string',
        'visibility' => 'string',
        'page_name' => 'string',
        'page_headline' => 'string',
        'breadcrumb_headline' => 'string',
        'page_image' => 'string',
        'breadcrumb_description' => 'string',
        'description' => 'string',
        'meta_title' => 'string',
        'meta_keyword' => 'string',
        'meta_description' => 'string',
        'status' => 'string',
    ];
}
