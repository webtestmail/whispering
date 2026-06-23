<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSections extends Model
{
    use HasFactory;

    protected $table = 'page_sections';

    protected $fillable = [
        'parent_id',
        'page_id',
        'default_section_name',
        'position_order',
        'section_title',
        'section_headline',
        'section_subheading',
        'description',
        'button_name',
        'button_link',
        'section_image',
        'more_images',
        'status',
        'video_link',
        'section_subtitle'
    ];

    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'page_id' => 'integer',
        'default_section_name' => 'string',
        'position_order' => 'integer',
        'section_title' => 'string',
        'section_headline' => 'string',
        'section_icon' => 'string',
        'description' => 'string',
        'button_name' => 'string',
        'button_link' => 'string',
        'section_image' => 'string',
        'status' => 'string',
    ];
}
