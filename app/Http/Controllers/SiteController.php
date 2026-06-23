<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function about()
    {
        return view('about');
    }

    public function theRetreat()
    {
        return view('the-retreat');
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

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }
}
