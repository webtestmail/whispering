<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'position_order',
        'slug',
        'status',
        'season_tag',
        'season_style',
        'months',
        'temperature',
        'title',
        'listing_description',
        'listing_image',
        'highlights',
        'link_text',
        'hero_subtitle',
        'hero_image',
        'hero_description',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    protected $casts = [
        'highlights' => 'array',
    ];

    public function sections()
    {
        return $this->hasMany(ExperienceSection::class)->whereNull('parent_id')->orderBy('position_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
