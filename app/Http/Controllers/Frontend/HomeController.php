<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\BlogPost;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\Slider;
use App\Models\HomeAbout;
use App\Models\HomeCta;

class HomeController extends Controller
{
    public function index(string $locale)
    {
        $sliders    = Slider::where('is_active', true)->orderBy('order')->get();
        $services   = Service::where('is_active', true)->orderBy('order')->limit(6)->get();
        $blogs      = BlogPost::where('is_active', true)->orderByDesc('published_at')->limit(3)->get();
        $portfolio  = PortfolioItem::where('is_active', true)->orderBy('order')->limit(3)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('order')->get();
        $partners   = Partner::where('is_active', true)->orderBy('order')->get();
        $homeAbout  = HomeAbout::first();
        $homeCta    = HomeCta::first();

        return view('frontend.home.index', compact(
            'locale', 'sliders', 'services', 'blogs', 'portfolio', 'testimonials', 'partners', 'homeAbout', 'homeCta'
        ));
    }
}
