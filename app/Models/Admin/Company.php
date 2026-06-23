<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    protected $fillable = [
        'company_icon',
        'company_logo',
        'company_footer_logo',
        'company_name',
        'get_updates_section',
        'socials_visibility',
        'facebook_url',
        'x_url',
        'linkedin_url',
        'youtube_url',
        'instagram_url',
        'footer_content_visibility',
        'footer_content',
        'phone',
        'whatsapp_phone',
        'alternate_phone',
        'email',
        'alternate_email',
        'footer_location',
        'location_visibility',
        'location',
        'alternate_location',
        'map_link_visibility',
        'copyright',
        'map_link',
        'newsletter_title',
        'newsletter_description',
        'newsletter_image'
    ];

    protected $casts = [
        'company_icon' => 'string',
        'company_logo' => 'string',
        'company_footer_logo' => 'string',
        'company_name' => 'string',
        'get_updates_section' => 'string',
        'socials_visibility' => 'string',
        'facebook_url' => 'string',
        'x_url' => 'string',
        'linkedin_url' => 'string',
        'youtube_url' => 'string',
        'instagram_url' => 'string',
        'footer_content_visibility' => 'string',
        'footer_content' => 'string',
        'phone' => 'string',
        'whatsapp_phone' => 'string',
        'alternate_phone' => 'string',
        'email' => 'string',
        'alternate_email' => 'string',
        'footer_location' => 'string',
        'location_visibility' => 'string',
        'location' => 'string',
        'alternate_location' => 'string',
        'map_link_visibility' => 'string',
        'map_link' => 'string',
        'copyright' => 'string'
    ];
}
