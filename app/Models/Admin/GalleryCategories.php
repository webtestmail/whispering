<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategories extends Model
{
    use HasFactory;

    protected $table = 'gallery_categories';

    protected $fillable = [
        'show_header',
        'name',
        'slug',
        'is_active',
        'position_order',
    ];

    protected $casts = [
        'id' => 'integer',
        'show_header' => 'boolean',
        'is_active' => 'boolean',
        'position_order' => 'integer',
    ];

    public function galleries(): HasMany
    {
        return $this->hasMany(Galleries::class, 'gallery_category_id');
    }
}
