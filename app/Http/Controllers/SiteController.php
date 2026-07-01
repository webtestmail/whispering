<?php

namespace App\Http\Controllers;

use App\Models\Admin\Pages;
use App\Models\Admin\PageSections;
use App\Models\Admin\Accommodation;
use App\Models\Admin\AccommodationSection;
use App\Models\Admin\Event;
use App\Models\Admin\EventSection;
use App\Models\Admin\Experience;
use App\Models\Admin\ExperienceSection;
use App\Models\Admin\LegalPage;

class SiteController extends Controller
{
    public function index()
    {
        $page = Pages::where('id', 1)->first();
        return view('index', ['page' => $page]);
    }
    public function location(){
        return view('location');
    }

    public function about()
    {
        return view('about');
    }

    public function theRetreat()
    {
        $page = Pages::where('id', 36)->first();
        $sections = PageSections::where('page_id', 36)
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with(['pagesubsections' => function ($query) {
                $query->where('status', 'active')->orderBy('position_order');
            }])
            ->orderBy('position_order')
            ->get()
            ->keyBy('default_section_name');

        return view('the-retreat', compact('page', 'sections'));
    }

    public function accommodation()
    {
        $page = Pages::where('client_page_urls', 'accommodation')->first();
        $sections = collect();

        if ($page) {
            $sections = PageSections::where('page_id', $page->id)
                ->whereNull('parent_id')
                ->where('status', 'active')
                ->orderBy('position_order')
                ->get()
                ->keyBy('default_section_name');
        }

        $accommodations = Accommodation::where('status', 'active')->orderBy('position_order')->get();

        return view('accomodation', compact('page', 'sections', 'accommodations'));
    }

    public function accommodationDetail($slug)
    {
        $accommodation = Accommodation::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $sections = AccommodationSection::where('accommodation_id', $accommodation->id)
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with(['subsections' => function ($query) {
                $query->where('status', 'active')->orderBy('position_order');
            }])
            ->orderBy('position_order')
            ->get()
            ->keyBy('default_section_name');

        $otherAccommodations = Accommodation::where('status', 'active')
            ->where('id', '!=', $accommodation->id)
            ->orderBy('position_order')
            ->limit(2)
            ->get();

        return view('accomodation-detail', compact('accommodation', 'sections', 'otherAccommodations'));
    }

    public function accommodationDetailLegacy()
    {
        $first = Accommodation::where('status', 'active')->orderBy('position_order')->first();

        if (!$first) {
            abort(404);
        }

        return redirect()->route('accommodation.detail', $first->slug);
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function experiences()
    {
        $page = Pages::where('client_page_urls', 'experiences')->first();
        $sections = collect();

        if ($page) {
            $sections = PageSections::where('page_id', $page->id)
                ->whereNull('parent_id')
                ->where('status', 'active')
                ->with(['pagesubsections' => function ($query) {
                    $query->where('status', 'active')->orderBy('position_order');
                }])
                ->orderBy('position_order')
                ->get()
                ->keyBy('default_section_name');
        }

        $experiences = Experience::where('status', 'active')->orderBy('position_order')->get();

        return view('experience', compact('page', 'sections', 'experiences'));
    }

    public function experienceDetail($slug)
    {
        $experience = Experience::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $sections = ExperienceSection::where('experience_id', $experience->id)
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with(['subsections' => function ($query) {
                $query->where('status', 'active')->orderBy('position_order');
            }])
            ->orderBy('position_order')
            ->get()
            ->keyBy('default_section_name');

        return view('experience-detail', compact('experience', 'sections'));
    }

    public function dining()
    {
        $page = Pages::where('client_page_urls', 'dining')->first();
        $sections = collect();

        if ($page) {
            $sections = PageSections::where('page_id', $page->id)
                ->whereNull('parent_id')
                ->where('status', 'active')
                ->with(['pagesubsections' => function ($query) {
                    $query->where('status', 'active')->orderBy('position_order');
                }])
                ->orderBy('position_order')
                ->get()
                ->keyBy('default_section_name');
        }

        return view('dining', compact('page', 'sections'));
    }

    public function events()
    {
        $page = Pages::where('client_page_urls', 'events')->first();
        $sections = collect();

        if ($page) {
            $sections = PageSections::where('page_id', $page->id)
                ->whereNull('parent_id')
                ->where('status', 'active')
                ->with(['pagesubsections' => function ($query) {
                    $query->where('status', 'active')->orderBy('position_order');
                }])
                ->orderBy('position_order')
                ->get()
                ->keyBy('default_section_name');
        }

        $events = Event::where('status', 'active')->orderBy('position_order')->get();

        return view('events', compact('page', 'sections', 'events'));
    }

    public function eventDetail($slug)
    {
        $event = Event::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $sections = EventSection::where('event_id', $event->id)
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with(['subsections' => function ($query) {
                $query->where('status', 'active')->orderBy('position_order');
            }])
            ->orderBy('position_order')
            ->get()
            ->keyBy('default_section_name');

        return view('event-detail', compact('event', 'sections'));
    }

    public function blog()
    {
        return view('blog');
    }

    public function blogDetail()
    {
        return view('blog-detail');
    }

    public function contact()
    {
        return view('contact');
    }

    public function enquire()
    {
        return view('enquire');
    }

    public function legalPage(string $slug)
    {
        $legalPage = LegalPage::where('page_slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('privacy-policy', compact('legalPage'));
    }
}
