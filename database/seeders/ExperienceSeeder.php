<?php

namespace Database\Seeders;

use App\Models\Admin\Experience;
use App\Models\Admin\ExperienceSection;
use App\Models\Admin\Pages;
use App\Models\Admin\PageSections;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $pageOrder = Pages::max('position_order');

        Pages::firstOrCreate(
            ['client_page_urls' => 'experiences'],
            [
                'position_order' => ($pageOrder !== null) ? $pageOrder + 1 : 1,
                'header_footer_name' => 'Experiences',
                'page_name' => 'Experiences',
                'page_headline' => 'Experiences',
                'breadcrumb_headline_headline' => 'Every Season Tells A Different Story',
                'breadcrumb_description' => 'From sun-drenched summer trails to snow-covered winter mornings — discover what awaits at every time of year.',
                'visibility' => 'none',
                'meta_title' => 'Experiences | Whispering Pines',
                'status' => 'active',
            ]
        );

        $listingPage = Pages::where('client_page_urls', 'experiences')->first();

        PageSections::firstOrCreate(
            ['page_id' => $listingPage->id, 'default_section_name' => 'why_come_here', 'parent_id' => null],
            [
                'position_order' => 1,
                'section_title' => 'Why Come Here',
                'section_headline' => 'More Than A Getaway',
                'description' => '<p class="exp-intro__text">Whispering Pines is not just a place to stay — it is a collection of moments shaped by the mountains, the forest, and the seasons.</p>',
                'status' => 'active',
            ]
        );

        PageSections::firstOrCreate(
            ['page_id' => $listingPage->id, 'default_section_name' => 'listing_intro', 'parent_id' => null],
            [
                'position_order' => 2,
                'section_title' => 'What Awaits You',
                'section_headline' => 'Explore All Experiences',
                'status' => 'active',
            ]
        );

        PageSections::firstOrCreate(
            ['page_id' => $listingPage->id, 'default_section_name' => 'exp_gallery', 'parent_id' => null],
            [
                'position_order' => 3,
                'section_title' => 'In The Moment',
                'section_headline' => 'Captured By Our Guests',
                'description' => 'Real moments, real people, real Himalayas.',
                'status' => 'active',
            ]
        );

        PageSections::firstOrCreate(
            ['page_id' => $listingPage->id, 'default_section_name' => 'exp_cta', 'parent_id' => null],
            [
                'position_order' => 4,
                'section_headline' => 'Which Season Calls To You?',
                'description' => 'Every visit is different.<br>Let us help you pick the perfect time to come.',
                'button_name' => 'Plan Your Experience',
                'button_link' => '/enquire/',
                'status' => 'active',
            ]
        );

        $items = [
            [
                'slug' => 'summer-at-whispering-pines',
                'position_order' => 1,
                'season_tag' => 'Summer',
                'season_style' => 'summer',
                'months' => 'Apr — Jun',
                'temperature' => '12°c — 22°c',
                'title' => 'Summer at Whispering Pines',
                'listing_description' => 'Lush green trails, crisp mountain air, blooming rhododendrons and long warm evenings under a canopy of stars.',
                'highlights' => ['Forest Treks', 'Nature Walks', 'Campfire Nights', 'Bird Watching'],
                'link_text' => 'Explore Summer',
                'hero_subtitle' => 'Experiences',
                'hero_description' => 'April through June — when the mountains turn their greenest.',
                'meta_title' => 'Summer at Whispering Pines | Experiences',
            ],
            [
                'slug' => 'winter-at-whispering-pines',
                'position_order' => 2,
                'season_tag' => 'Winter',
                'season_style' => 'winter',
                'months' => 'Nov — Feb',
                'temperature' => '−2°c — 10°c',
                'title' => 'Winter at Whispering Pines',
                'listing_description' => 'Snow-covered pine forests, steaming cups of kahwa by the fire, and the kind of silence only a Himalayan winter can offer.',
                'highlights' => ['Snowfall Walks', 'Bonfire Evenings', 'Snow Trekking', 'Hot Springs'],
                'link_text' => 'Explore Winter',
                'hero_subtitle' => 'Experiences',
                'hero_description' => 'November through February — when the mountains wear white.',
            ],
            [
                'slug' => 'round-the-year',
                'position_order' => 3,
                'season_tag' => 'All Year',
                'season_style' => 'all',
                'months' => 'Jan — Dec',
                'temperature' => 'Year Round',
                'title' => 'Round the Year at Whispering Pines',
                'listing_description' => 'Adventure doesn\'t follow a calendar. Rappelling, river crossing, rock climbing and team challenges are available every season.',
                'highlights' => ['Rappelling', 'Rock Climbing', 'River Crossing', 'Team Activities'],
                'link_text' => 'Explore Adventures',
                'hero_subtitle' => 'Experiences',
                'hero_description' => 'Adventure available every season — for groups, families and solo adventurers alike.',
            ],
            [
                'slug' => 'star-gazing-at-kanatal',
                'position_order' => 4,
                'season_tag' => 'Nights',
                'season_style' => 'night',
                'months' => 'Best: Oct — Mar',
                'temperature' => 'Clear Skies',
                'title' => 'Star Gazing at Kanatal',
                'listing_description' => 'At 7,500 feet with minimal light pollution, Kanatal offers one of India\'s clearest night skies.',
                'highlights' => ['Telescope Viewing', 'Guided Sessions', 'Milky Way', 'Constellation Maps'],
                'link_text' => 'Explore Star Gazing',
                'hero_subtitle' => 'Experiences',
                'hero_description' => 'Guided astronomy sessions and open-air stargazing on the forest deck.',
            ],
        ];

        foreach ($items as $item) {
            $experience = Experience::firstOrCreate(['slug' => $item['slug']], array_merge($item, ['status' => 'active']));

            foreach (['editorial', 'what_to_expect', 'activities', 'day_timeline', 'best_months', 'gallery', 'booking_sidebar', 'exp_cta'] as $i => $name) {
                ExperienceSection::firstOrCreate(
                    ['experience_id' => $experience->id, 'default_section_name' => $name, 'parent_id' => null],
                    ['position_order' => $i + 1, 'status' => 'active']
                );
            }
        }

        $this->seedSummerDetail(Experience::where('slug', 'summer-at-whispering-pines')->first());
    }

    private function seedSummerDetail(?Experience $experience): void
    {
        if (!$experience) {
            return;
        }

        $sections = ExperienceSection::where('experience_id', $experience->id)
            ->whereNull('parent_id')
            ->get()
            ->keyBy('default_section_name');

        $editorial = $sections->get('editorial');
        if ($editorial) {
            $editorial->update([
                'section_headline' => 'Summer here isn\'t just a season. It is the mountain\'s way of welcoming you home.',
            ]);
            $paragraphs = [
                'When the rest of India bakes under a relentless sun, Kanatal sits quietly at 7,500 feet — wrapped in cool air, the scent of pine, and a light that makes everything look like a painting.',
                'The forests turn impossibly green. Rhododendrons bloom along the trails. Days are long and warm enough to explore, evenings cool enough to sit by a fire.',
                'Whether you\'re a family escaping the Delhi heat, a couple looking for quiet, or a group craving adventure — summer delivers everything the Himalayas promise.',
            ];
            foreach ($paragraphs as $i => $text) {
                ExperienceSection::firstOrCreate(
                    ['experience_id' => $experience->id, 'parent_id' => $editorial->id, 'position_order' => $i + 1],
                    ['description' => $text, 'status' => 'active']
                );
            }
        }

        $expect = $sections->get('what_to_expect');
        if ($expect) {
            $expect->update(['section_headline' => 'What To Expect']);
            $items = [
                ['Temperature', '12°c — 22°c'],
                ['Best Months', 'April — June'],
                ['Ideal For', 'Families, Couples, Groups'],
                ['Landscape', 'Lush Green, Full Bloom'],
                ['Day Length', 'Long — 14+ hrs daylight'],
                ['Crowd Level', 'Moderate — Book Early'],
            ];
            foreach ($items as $i => [$label, $value]) {
                ExperienceSection::firstOrCreate(
                    ['experience_id' => $experience->id, 'parent_id' => $expect->id, 'section_subheading' => $label],
                    ['section_headline' => $value, 'position_order' => $i + 1, 'status' => 'active']
                );
            }
        }

        $activities = $sections->get('activities');
        if ($activities) {
            $activities->update([
                'section_headline' => 'Summer Experiences',
                'section_subtitle' => 'Hand-picked activities that make the most of Kanatal\'s summer.',
            ]);
        }

        $timeline = $sections->get('day_timeline');
        if ($timeline) {
            $timeline->update([
                'section_headline' => 'A Summer Day Here',
                'section_subtitle' => 'No two days are the same — but here\'s what one might feel like.',
            ]);
        }

        $months = $sections->get('best_months');
        if ($months) {
            $months->update(['section_headline' => 'Best Time To Visit']);
            $statusMap = [
                'Jan' => 'off', 'Feb' => 'off', 'Mar' => 'partial',
                'Apr' => 'active', 'May' => 'peak', 'Jun' => 'peak',
                'Jul' => 'partial', 'Aug' => 'partial',
                'Sep' => 'off', 'Oct' => 'off', 'Nov' => 'off', 'Dec' => 'off',
            ];
            foreach ($statusMap as $month => $status) {
                ExperienceSection::firstOrCreate(
                    ['experience_id' => $experience->id, 'parent_id' => $months->id, 'section_subheading' => $month],
                    ['section_subtitle' => $status, 'position_order' => array_search($month, array_keys($statusMap)) + 1, 'status' => 'active']
                );
            }
        }

        $booking = $sections->get('booking_sidebar');
        if ($booking) {
            $booking->update([
                'section_subheading' => 'Summer Stay',
                'section_headline' => 'Plan Your Visit',
                'description' => 'Share your details and we\'ll get back within 24 hours.',
            ]);
        }

        $cta = $sections->get('exp_cta');
        if ($cta) {
            $cta->update([
                'section_headline' => 'Summer Is Calling',
                'description' => 'Limited tents. Unlimited mountains.<br>Book before the season fills up.',
                'button_name' => 'Enquire Now',
                'button_link' => '/enquire/',
            ]);
        }
    }
}
