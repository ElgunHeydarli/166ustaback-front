<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(string $locale)
    {
        $services = Service::where('is_active', true)->orderBy('order')->get();
        return view('frontend.services.index', compact('locale', 'services'));
    }

    public function show(string $locale, string $slug)
    {
        $service = Service::where('is_active', true)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale}')) = ?", [$slug])
            ->firstOrFail();

        $hreflangUrls = [
            'az' => route('services.show', ['az', $service->getTranslation('slug', 'az') ?: $service->getTranslation('slug', 'az')]),
            'en' => route('services.show', ['en', $service->getTranslation('slug', 'en') ?: $service->getTranslation('slug', 'az')]),
            'ru' => route('services.show', ['ru', $service->getTranslation('slug', 'ru') ?: $service->getTranslation('slug', 'az')]),
        ];

        return view('frontend.services.show', compact('locale', 'service', 'hreflangUrls'));
    }
}
