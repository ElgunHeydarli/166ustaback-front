<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Box;
use App\Models\Campaign;
use App\Models\ContactMessage;
use App\Models\Partner;
use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services'         => Service::count(),
            'portfolio'        => PortfolioItem::count(),
            'blogs'            => BlogPost::count(),
            'boxes'            => Box::count(),
            'campaigns'        => Campaign::count(),
            'partners'         => Partner::count(),
            'testimonials'     => Testimonial::count(),
            'unread_messages'  => ContactMessage::where('is_read', false)->count(),
            'total_messages'   => ContactMessage::count(),
        ];

        $latest_messages = ContactMessage::with('service')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latest_messages'));
    }
}
