<?php

namespace Database\Seeders;

use App\Models\Admin\Accommodation;
use App\Models\Admin\AccommodationSection;
use App\Models\Admin\Pages;
use App\Models\Admin\PageSections;
use Illuminate\Database\Seeder;

class AccommodationSeeder extends Seeder
{
    public function run(): void
    {
        $pageOrder = Pages::max('position_order');

        Pages::firstOrCreate(
            ['client_page_urls' => 'accommodation'],
            [
                'position_order' => ($pageOrder !== null) ? $pageOrder + 1 : 1,
                'header_footer_name' => 'Accommodation',
                'page_name' => 'Accommodation',
                'page_headline' => 'Accommodation',
                'breadcrumb_headline' => 'Accomodation',
                'breadcrumb_description' => 'Crafted For Those Seeking <br> Silence Beyond The Mountains',
                'description' => 'A retreat born from the timeless beauty of the Himalayas.',
                'visibility' => 'none',
                'meta_title' => 'Accommodation | Whispering Pines',
                'status' => 'active',
            ]
        );

        $listingPage = Pages::where('client_page_urls', 'accommodation')->first();

        PageSections::firstOrCreate(
            ['page_id' => $listingPage->id, 'default_section_name' => 'listing_intro', 'parent_id' => null],
            ['position_order' => 1, 'section_title' => 'Where You\'ll Stay', 'section_headline' => 'Choose Your Retreat', 'status' => 'active']
        );

        $items = [
            [
                'slug' => 'alpine-swiss-tents',
                'position_order' => 1,
                'tag' => 'Premium Stay',
                'badge' => '8 Units',
                'title' => 'Alpine Swiss Tents',
                'listing_description' => '12\' x 12\' Swiss Tents with metal frame made of high-quality weatherproof canvas.',
                'share_basis' => 'Twin / Triple Share Basis',
                'reverse_layout' => false,
                'amenities' => [['label' => 'Attached Bath'], ['label' => 'Free Wifi'], ['label' => 'Tea / Coffee'], ['label' => 'Charging Point']],
                'hero_subtitle' => 'Accommodation',
                'hero_description' => 'Premium canvas tents with mountain views and every comfort.',
            ],
            [
                'slug' => 'adventure-dome-camping-tents',
                'position_order' => 2,
                'tag' => 'Adventure Stay',
                'badge' => '50–60 Capacity',
                'title' => 'Adventure Dome & Camping Tents',
                'listing_description' => 'Made from imported nylon, these tents provide the closest interaction with the outdoors.',
                'share_basis' => 'Twin / Quad Share Basis',
                'reverse_layout' => true,
                'amenities' => [['label' => 'Ground Bedding'], ['label' => 'Free Wifi'], ['label' => 'Shared Bath'], ['label' => 'Sleeping Bags']],
                'hero_subtitle' => 'Accommodation',
                'hero_description' => 'Adventure camping under the Himalayan stars.',
            ],
            [
                'slug' => 'alpine-mountain-cottages',
                'position_order' => 3,
                'tag' => 'Signature Stay',
                'badge' => '2 Cottages',
                'title' => 'Alpine Mountain Cottages',
                'listing_description' => 'Valley-facing independent cottage rooms with a private sit-out.',
                'share_basis' => 'Double / Twin Share Basis',
                'reverse_layout' => false,
                'amenities' => [['label' => 'Attached Bath'], ['label' => 'LCD TV'], ['label' => 'Free Wifi'], ['label' => 'Private Sit-out']],
                'hero_subtitle' => 'Accommodation',
                'hero_description' => 'Signature cottages with panoramic valley views.',
            ],
        ];

        foreach ($items as $item) {
            $accommodation = Accommodation::firstOrCreate(['slug' => $item['slug']], array_merge($item, ['status' => 'active']));

            foreach (['overview', 'gallery', 'features', 'inclusions', 'tariff', 'policies', 'other_stays', 'accom_cta'] as $i => $name) {
                AccommodationSection::firstOrCreate(
                    ['accommodation_id' => $accommodation->id, 'default_section_name' => $name, 'parent_id' => null],
                    ['position_order' => $i + 1, 'status' => 'active']
                );
            }
        }
    }
}
