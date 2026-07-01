<?php

namespace Database\Seeders;

use App\Models\Admin\Event;
use App\Models\Admin\EventSection;
use App\Models\Admin\Pages;
use App\Models\Admin\PageSections;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $pageOrder = Pages::max('position_order');

        Pages::firstOrCreate(
            ['client_page_urls' => 'events'],
            [
                'position_order' => ($pageOrder !== null) ? $pageOrder + 1 : 1,
                'header_footer_name' => 'Events & Groups',
                'page_name' => 'Events & Groups',
                'page_headline' => 'Events & Groups',
                'breadcrumb_headline' => 'Crafted For Those Seeking <br> Silence Beyond The Mountains',
                'breadcrumb_description' => 'A retreat born from the timeless beauty of the Himalayas.',
                'visibility' => 'none',
                'meta_title' => 'Events & Groups | Whispering Pines',
                'status' => 'active',
            ]
        );

        $listingPage = Pages::where('client_page_urls', 'events')->first();

        PageSections::firstOrCreate(
            ['page_id' => $listingPage->id, 'default_section_name' => 'listing_intro', 'parent_id' => null],
            [
                'position_order' => 1,
                'section_title' => 'Events & Groups',
                'section_headline' => 'Curated Experiences For Every Group',
                'description' => 'Whether you\'re planning a corporate retreat, school camp, family celebration or wellness gathering, Whispering Pines offers the perfect mountain setting for memorable experiences.',
                'status' => 'active',
            ]
        );

        $items = [
            [
                'slug' => 'corporate-offsites',
                'position_order' => 1,
                'title' => 'Corporate Offsites',
                'listing_description' => 'Team bonding, strategy sessions and memorable retreats in nature.',
                'link_text' => 'Explore More',
                'hero_subtitle' => 'Events & Groups',
                'hero_description' => 'A retreat born from the timeless beauty of the Himalayas.',
                'meta_title' => 'Corporate Offsites | Whispering Pines',
            ],
            [
                'slug' => 'school-youth-camps',
                'position_order' => 2,
                'title' => 'School & Youth Camps',
                'listing_description' => 'Educational adventures, outdoor learning and fun-filled activities.',
                'link_text' => 'Explore More',
                'hero_subtitle' => 'Events & Groups',
                'meta_title' => 'School & Youth Camps | Whispering Pines',
            ],
            [
                'slug' => 'family-gatherings',
                'position_order' => 3,
                'title' => 'Family Gatherings',
                'listing_description' => 'Celebrate togetherness amidst breathtaking Himalayan surroundings.',
                'link_text' => 'Explore More',
                'hero_subtitle' => 'Events & Groups',
                'meta_title' => 'Family Gatherings | Whispering Pines',
            ],
            [
                'slug' => 'outbound-training',
                'position_order' => 4,
                'title' => 'Outbound Training',
                'listing_description' => 'Leadership, collaboration and experiential learning programs.',
                'link_text' => 'Explore More',
                'hero_subtitle' => 'Events & Groups',
                'meta_title' => 'Outbound Training | Whispering Pines',
            ],
            [
                'slug' => 'yoga-camps',
                'position_order' => 5,
                'title' => 'Yoga Camps',
                'listing_description' => 'Reconnect with yourself through wellness, mindfulness and nature.',
                'link_text' => 'Explore More',
                'hero_subtitle' => 'Events & Groups',
                'meta_title' => 'Yoga Camps | Whispering Pines',
            ],
            [
                'slug' => 'class-reunions',
                'position_order' => 6,
                'title' => 'Class Reunions',
                'listing_description' => 'Relive memories and create new ones in a peaceful mountain retreat.',
                'link_text' => 'Explore More',
                'hero_subtitle' => 'Events & Groups',
                'meta_title' => 'Class Reunions | Whispering Pines',
            ],
        ];

        foreach ($items as $item) {
            $event = Event::firstOrCreate(['slug' => $item['slug']], array_merge($item, ['status' => 'active']));

            foreach (['event_intro', 'event_stats', 'event_highlights', 'event_experiences', 'event_cta'] as $i => $name) {
                EventSection::firstOrCreate(
                    ['event_id' => $event->id, 'default_section_name' => $name, 'parent_id' => null],
                    ['position_order' => $i + 1, 'status' => 'active']
                );
            }
        }

        $this->seedCorporateDetail(Event::where('slug', 'corporate-offsites')->first());
    }

    private function seedCorporateDetail(?Event $event): void
    {
        if (!$event) {
            return;
        }

        $sections = EventSection::where('event_id', $event->id)
            ->whereNull('parent_id')
            ->get()
            ->keyBy('default_section_name');

        $intro = $sections->get('event_intro');
        if ($intro) {
            $intro->update([
                'section_subtitle' => 'Experience Overview',
                'section_headline' => 'Meaningful Gatherings In The Heart Of Nature',
            ]);
            $paragraphs = [
                'Surrounded by forests, mountain views and peaceful landscapes, Whispering Pines offers a unique setting for group experiences, retreats and special occasions.',
                'Whether it\'s a corporate offsite, school camp, family gathering or wellness retreat, every experience is thoughtfully designed to bring people together.',
            ];
            foreach ($paragraphs as $i => $text) {
                EventSection::firstOrCreate(
                    ['event_id' => $event->id, 'parent_id' => $intro->id, 'position_order' => $i + 1],
                    ['description' => $text, 'status' => 'active']
                );
            }
        }

        $stats = $sections->get('event_stats');
        if ($stats) {
            $statItems = [
                ['50+', 'Guests'],
                ['15+', 'Activities'],
                ['10+', 'Years Experience'],
            ];
            foreach ($statItems as $i => [$value, $label]) {
                EventSection::firstOrCreate(
                    ['event_id' => $event->id, 'parent_id' => $stats->id, 'section_subheading' => $label],
                    ['section_headline' => $value, 'position_order' => $i + 1, 'status' => 'active']
                );
            }
        }

        $highlights = $sections->get('event_highlights');
        if ($highlights) {
            $highlights->update([
                'section_subtitle' => 'Why Choose Us',
                'section_headline' => 'Designed For Memorable Experiences',
            ]);
            $items = [
                ['Scenic Location', 'Stunning mountain surroundings and fresh air.'],
                ['Comfortable Stay', 'Cozy rooms and cottages for every group size.'],
                ['Custom Activities', 'Programs tailored to your event goals.'],
                ['Dining Experience', 'Fresh meals served with beautiful views.'],
            ];
            foreach ($items as $i => [$title, $desc]) {
                EventSection::firstOrCreate(
                    ['event_id' => $event->id, 'parent_id' => $highlights->id, 'section_headline' => $title],
                    ['description' => $desc, 'position_order' => $i + 1, 'status' => 'active']
                );
            }
        }

        $experiences = $sections->get('event_experiences');
        if ($experiences) {
            $experiences->update([
                'section_subtitle' => 'Experiences',
                'section_headline' => 'Moments That Bring People Together',
            ]);
            $items = [
                ['Outdoor Activities', 'Guided adventures and engaging group challenges.'],
                ['Bonfire Evenings', 'Relax, connect and create lasting memories.'],
                ['Nature Walks', 'Discover peaceful trails and mountain views.'],
            ];
            foreach ($items as $i => [$title, $desc]) {
                EventSection::firstOrCreate(
                    ['event_id' => $event->id, 'parent_id' => $experiences->id, 'section_headline' => $title],
                    ['description' => $desc, 'position_order' => $i + 1, 'status' => 'active']
                );
            }
        }

        $cta = $sections->get('event_cta');
        if ($cta) {
            $cta->update([
                'section_headline' => 'Plan Your Group Event',
                'description' => 'Tell us about your group and we\'ll help craft the perfect mountain experience.',
                'button_name' => 'Enquire Now',
                'button_link' => '/enquire/',
            ]);
        }
    }
}
