<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class EventSection extends Model
{
    protected $fillable = [
        'event_id',
        'parent_id',
        'position_order',
        'default_section_name',
        'section_title',
        'section_subtitle',
        'section_headline',
        'description',
        'button_name',
        'button_link',
        'section_subheading',
        'section_image',
        'more_images',
        'video_link',
        'status',
    ];

    public function subsections()
    {
        return $this->hasMany(EventSection::class, 'parent_id', 'id');
    }
}
