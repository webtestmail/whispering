<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    use HasFactory;

    protected $table = 'legal_pages';

    protected $fillable = [
        'position_order',
        'page_slug',
        'page_name',
        'title',
        'description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'position_order' => 'integer',
        'page_slug' => 'string',
        'page_name' => 'string',
        'title' => 'string',
        'description' => 'string',
        'meta_title' => 'string',
        'meta_keyword' => 'string',
        'meta_description' => 'string',
        'status' => 'string',
    ];
}
