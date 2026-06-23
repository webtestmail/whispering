<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'position_order',
        'banner_title',
        'banner_headline',
        'description',
        'button_name',
        'button_link',
        'other_button_name',
        'other_button_link',
        'banner_image',
        'banner_icons',
        'status'
    ];

    protected $casts = [
        'id' => 'integer',
        'position_order' => 'integer',
        'banner_title' => 'string',
        'banner_headline' => 'string',
        'description' => 'string',
        'button_name' => 'string',
        'button_link' => 'string',
        'other_button_name' => 'string',
        'other_button_link' => 'string',
        'banner_image' => 'string',
        'banner_icons' => 'string',
        'status' => 'string',
    ];

    // Relationship to Images model
    public function icons()
    {
        return $this->hasMany(Images::class, 'reference_id', 'id')->where('status', 'active');
    }
}
