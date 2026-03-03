<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;

class PortfolioController extends Controller
{
    public function index(string $locale)
    {
        $items = PortfolioItem::where('is_active', true)->orderBy('order')->paginate(9);
        return view('frontend.portfolio.index', compact('locale', 'items'));
    }

    public function show(string $locale, string $slug)
    {
        $item = PortfolioItem::where('is_active', true)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale}')) = ?", [$slug])
            ->firstOrFail();

        $hreflangUrls = [
            'az' => route('portfolio.show', ['az', $item->getTranslation('slug', 'az') ?: $item->getTranslation('slug', 'az')]),
            'en' => route('portfolio.show', ['en', $item->getTranslation('slug', 'en') ?: $item->getTranslation('slug', 'az')]),
            'ru' => route('portfolio.show', ['ru', $item->getTranslation('slug', 'ru') ?: $item->getTranslation('slug', 'az')]),
        ];

        return view('frontend.portfolio.show', compact('locale', 'item', 'hreflangUrls'));
    }
}
