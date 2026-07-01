<?php

namespace Database\Seeders;

use App\Models\Admin\PageSections;
use Illuminate\Database\Seeder;

class TheRetreatPageSectionsSeeder extends Seeder
{
    /**
     * Scaffold CMS sections for "The Retreat" page (page id 36).
     * Run: php artisan db:seed --class=TheRetreatPageSectionsSeeder
     */
    public function run(): void
    {
        $pageId = 36;

        $sections = [
            ['default_section_name' => 'brand_story', 'position_order' => 1],
            ['default_section_name' => 'founder', 'position_order' => 2],
            ['default_section_name' => 'journey', 'position_order' => 3],
            ['default_section_name' => 'difference', 'position_order' => 4],
            ['default_section_name' => 'cinematic_video', 'position_order' => 5],
            ['default_section_name' => 'story_gallery', 'position_order' => 6],
            ['default_section_name' => 'values', 'position_order' => 7],
            ['default_section_name' => 'retreat_cta', 'position_order' => 8],
        ];

        foreach ($sections as $section) {
            PageSections::firstOrCreate(
                [
                    'page_id' => $pageId,
                    'default_section_name' => $section['default_section_name'],
                    'parent_id' => null,
                ],
                [
                    'position_order' => $section['position_order'],
                    'status' => 'active',
                ]
            );
        }
    }
}
