<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Box;
use App\Models\Campaign;
use App\Models\PortfolioItem;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index()
    {
        $services  = Service::where('is_active', true)->orderBy('order')->get();
        $blogs     = BlogPost::where('is_active', true)->orderByDesc('published_at')->get();
        $portfolio = PortfolioItem::where('is_active', true)->orderBy('order')->get();
        $boxes     = Box::where('is_active', true)->orderBy('order')->get();
        $campaigns = Campaign::where('is_active', true)->orderByDesc('created_at')->get();

        return response()
            ->view('sitemap', compact('services', 'blogs', 'portfolio', 'boxes', 'campaigns'))
            ->header('Content-Type', 'application/xml');
    }
}
