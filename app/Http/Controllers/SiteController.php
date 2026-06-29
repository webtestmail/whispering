<?php

namespace App\Http\Controllers;

use App\Models\Admin\Pages;

class SiteController extends Controller
{
    public function index()
    {
        $page = Pages::where('id', 1)->first();
        return view('index', ['page' => $page]);
    }

    public function about()
    {
        return view('about');
    }

    public function theRetreat()
    {
        $page = Pages::where('id', 36)->first();
        return view('the-retreat', ['page' => $page]);
    }

    public function accommodation()
    {
        return view('accomodation');
    }

    public function accommodationDetail()
    {
        return view('accomodation-detail');
    }

    public function location()
    {
        return view('location');
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function experiences()
    {
        return view('experience');
    }

    public function experienceDetail()
    {
        return view('experience-detail');
    }

    public function dining()
    {
        return view('dining');
    }

    public function events()
    {
        return view('events');
    }

    public function eventDetail()
    {
        return view('event-detail');
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

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }
}
