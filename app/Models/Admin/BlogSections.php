<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogSections extends Model
{
    use HasFactory;

    protected $table = 'blog_sections';

    protected $fillable = [
        'blog_id',
        'position_order',
        'default_section_name',
        'section_title',
        'section_headline',
        'description',
        'section_image',
        'status'
    ];

    protected $casts = [
        'id' => 'integer',
        'blog_id' => 'integer',
        'position_order' => 'integer',
        'default_section_name' => 'string',
        'section_title' => 'string',
        'section_headline' => 'string',
        'description' => 'string',
        'section_image' => 'string',
        'status' => 'string',
    ];
}
