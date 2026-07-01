<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'position_order',
        'slug',
        'status',
        'title',
        'listing_description',
        'listing_image',
        'link_text',
        'hero_subtitle',
        'hero_image',
        'hero_description',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    public function sections()
    {
        return $this->hasMany(EventSection::class)->whereNull('parent_id')->orderBy('position_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
