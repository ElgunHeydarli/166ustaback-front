<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\HomeAbout;
use App\Models\HomeWhyUs;
use App\Models\Partner;
use App\Models\PrivacyPage;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about(string $locale)
    {
        $about      = HomeAbout::first();
        $whyUs      = HomeWhyUs::first();
        $partners   = Partner::where('is_active', true)->orderBy('order')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('order')->get();

        return view('frontend.pages.about', compact('locale', 'about', 'whyUs', 'partners', 'testimonials'));
    }

    public function contact(string $locale)
    {
        $services = Service::where('is_active', true)->orderBy('order')->get();
        return view('frontend.pages.contact', compact('locale', 'services'));
    }

    public function contactPost(Request $request, string $locale)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'phone'      => 'required|string|max:20',
            'service_id' => 'nullable|exists:services,id',
            'message'    => 'nullable|string|max:1000',
        ]);

        ContactMessage::create($request->only(['name', 'phone', 'service_id', 'message']));

        return back()->with('success', 'Müraciətiniz qəbul edildi. Tezliklə əlaqə saxlayacağıq!');
    }

    public function privacy(string $locale)
    {
        $page = PrivacyPage::first();
        return view('frontend.pages.privacy', compact('locale', 'page'));
    }
}
