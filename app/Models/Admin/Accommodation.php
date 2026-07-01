<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $fillable = [
        'position_order',
        'slug',
        'status',
        'tag',
        'badge',
        'title',
        'listing_description',
        'listing_image',
        'share_basis',
        'reverse_layout',
        'amenities',
        'hero_subtitle',
        'hero_image',
        'hero_description',
        'button_name',
        'button_link',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    protected $casts = [
        'reverse_layout' => 'boolean',
        'amenities' => 'array',
    ];

    public function sections()
    {
        return $this->hasMany(AccommodationSection::class)->whereNull('parent_id')->orderBy('position_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
