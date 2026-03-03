<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Box;

class BoxController extends Controller
{
    public function index(string $locale)
    {
        $boxes = Box::where('is_active', true)->orderBy('order')->get();
        return view('frontend.boxes.index', compact('locale', 'boxes'));
    }

    public function show(string $locale, string $slug)
    {
        $box = Box::where('is_active', true)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale}')) = ?", [$slug])
            ->firstOrFail();

        $hreflangUrls = [
            'az' => route('boxes.show', ['az', $box->getTranslation('slug', 'az') ?: $box->getTranslation('slug', 'az')]),
            'en' => route('boxes.show', ['en', $box->getTranslation('slug', 'en') ?: $box->getTranslation('slug', 'az')]),
            'ru' => route('boxes.show', ['ru', $box->getTranslation('slug', 'ru') ?: $box->getTranslation('slug', 'az')]),
        ];

        return view('frontend.boxes.show', compact('locale', 'box', 'hreflangUrls'));
    }
}
