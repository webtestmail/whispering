<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'category_id',
        'blog_tags',
        'position_order',
        'blog_headline',
        'blog_url',
        'short_description',
        'description',
        'breadcrumb_image',
        'blog_image',
        'show_in_categories',
        'written_by',
        'writer_designation',
        'writer_description',
        'writer_image',
        'writer_instagram',
        'writer_linkedin',
        'writer_x',
        'writer_personal',
        'writer_facebook',
        'writer_threads',
        'post_date',
        'is_featured',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status'
    ];

    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'blog_tags' => 'string',
        'position_order' => 'integer',
        'blog_headline' => 'string',
        'blog_url' => 'string',
        'short_description' => 'string',
        'description' => 'string',
        'breadcrumb_image' => 'string',
        'blog_image' => 'string',
        'show_in_categories' => 'string',
        'written_by' => 'string',
        'writer_designation' => 'string',
        'writer_description' => 'string',
        'writer_image' => 'string',
        'writer_instagram' => 'string',
        'writer_linkedin' => 'string',
        'writer_x' => 'string',
        'writer_personal' => 'string',
        'writer_facebook' => 'string',
        'writer_threads' => 'string',
        'post_date' => 'date',
        'is_featured' => 'integer',
        'meta_title' => 'string',
        'meta_keyword' => 'string',
        'meta_description' => 'string',
        'status' => 'string',
    ];
}
