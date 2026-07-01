<?php

namespace Database\Seeders;

use App\Models\Admin\Pages;
use App\Models\Admin\PageSections;
use Illuminate\Database\Seeder;

class DiningSeeder extends Seeder
{
    /**
     * Scaffold CMS content for the Dining page.
     * Run: php artisan db:seed --class=DiningSeeder
     */
    public function run(): void
    {
        $pageOrder = Pages::max('position_order');

        Pages::firstOrCreate(
            ['client_page_urls' => 'dining'],
            [
                'position_order' => ($pageOrder !== null) ? $pageOrder + 1 : 1,
                'header_footer_name' => 'Dining',
                'page_name' => 'Dining',
                'page_headline' => 'Dining',
                'breadcrumb_headline' => 'Dining',
                'breadcrumb_description' => 'Crafted For Those Seeking <br> Silence Beyond The Mountains',
                'description' => 'A retreat born from the timeless beauty of the Himalayas.',
                'visibility' => 'none',
                'meta_title' => 'Dining | Whispering Pines',
                'status' => 'active',
            ]
        );

        $page = Pages::where('client_page_urls', 'dining')->firstOrFail();

        $diningIntro = PageSections::firstOrCreate(
            ['page_id' => $page->id, 'default_section_name' => 'dining_intro', 'parent_id' => null],
            [
                'position_order' => 1,
                'section_title' => 'Dining Experience',
                'section_headline' => 'Flavours Inspired By The Mountains',
                'description' => 'Enjoy thoughtfully prepared meals crafted from fresh ingredients, local produce, and timeless recipes. Every dining experience is designed to complement the peaceful surroundings of Whispering Pines.',
                'status' => 'active',
            ]
        );

        $introFeatures = [
            ['Multi Cuisine', 'Indian, Continental & local favourites.'],
            ['Fresh Ingredients', 'Locally sourced whenever possible.'],
            ['Scenic Dining', 'Meals served with breathtaking views.'],
        ];

        foreach ($introFeatures as $i => [$title, $text]) {
            PageSections::firstOrCreate(
                ['page_id' => $page->id, 'parent_id' => $diningIntro->id, 'section_headline' => $title],
                [
                    'position_order' => $i + 1,
                    'description' => $text,
                    'status' => 'active',
                ]
            );
        }

        $signatureDining = PageSections::firstOrCreate(
            ['page_id' => $page->id, 'default_section_name' => 'signature_dining', 'parent_id' => null],
            [
                'position_order' => 2,
                'section_title' => 'Highlights',
                'section_headline' => 'Signature Dining Moments',
                'status' => 'active',
            ]
        );

        $signatureItems = [
            ['Breakfast With The Mountains', 'Begin your day with fresh flavours and panoramic views.'],
            ['Traditional Garhwali Cuisine', 'Discover authentic regional flavours and local recipes.'],
            ['Evening Tea & Conversations', 'Relax with warm refreshments as the sun sets.'],
        ];

        foreach ($signatureItems as $i => [$title, $text]) {
            PageSections::firstOrCreate(
                ['page_id' => $page->id, 'parent_id' => $signatureDining->id, 'section_headline' => $title],
                [
                    'position_order' => $i + 1,
                    'description' => $text,
                    'status' => 'active',
                ]
            );
        }

        $cuisineSection = PageSections::firstOrCreate(
            ['page_id' => $page->id, 'default_section_name' => 'cuisine_section', 'parent_id' => null],
            [
                'position_order' => 3,
                'section_title' => 'What We Serve',
                'section_headline' => 'Something For Every Taste',
                'status' => 'active',
            ]
        );

        foreach (['Indian', 'Continental', 'Chinese', 'Local Cuisine'] as $i => $name) {
            PageSections::firstOrCreate(
                ['page_id' => $page->id, 'parent_id' => $cuisineSection->id, 'section_headline' => $name],
                [
                    'position_order' => $i + 1,
                    'status' => 'active',
                ]
            );
        }

        PageSections::firstOrCreate(
            ['page_id' => $page->id, 'default_section_name' => 'food_gallery', 'parent_id' => null],
            [
                'position_order' => 4,
                'section_title' => 'Gallery',
                'section_headline' => 'A Taste Of Whispering Pines',
                'status' => 'active',
            ]
        );
    }
}
