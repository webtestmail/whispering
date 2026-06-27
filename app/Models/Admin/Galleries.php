<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Galleries extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = [
        'gallery_category_id',
        'title',
        'slug',
        'short_description',
        'image',
        'is_feature',
        'is_active',
        'position_order',
    ];

    protected $casts = [
        'id' => 'integer',
        'gallery_category_id' => 'integer',
        'is_feature' => 'boolean',
        'is_active' => 'boolean',
        'position_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategories::class, 'gallery_category_id');
    }
}
