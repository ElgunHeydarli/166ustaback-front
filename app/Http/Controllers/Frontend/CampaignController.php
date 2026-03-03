<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index(string $locale)
    {
        $campaigns = Campaign::where('is_active', true)->orderByDesc('created_at')->get();
        return view('frontend.campaigns.index', compact('locale', 'campaigns'));
    }

    public function show(string $locale, string $slug)
    {
        $campaign = Campaign::where('is_active', true)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale}')) = ?", [$slug])
            ->firstOrFail();

        $hreflangUrls = [
            'az' => route('campaigns.show', ['az', $campaign->getTranslation('slug', 'az') ?: $campaign->getTranslation('slug', 'az')]),
            'en' => route('campaigns.show', ['en', $campaign->getTranslation('slug', 'en') ?: $campaign->getTranslation('slug', 'az')]),
            'ru' => route('campaigns.show', ['ru', $campaign->getTranslation('slug', 'ru') ?: $campaign->getTranslation('slug', 'az')]),
        ];

        return view('frontend.campaigns.show', compact('locale', 'campaign', 'hreflangUrls'));
    }
}
