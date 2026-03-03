<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index(string $locale)
    {
        $search = request('search');
        $tag    = request('tag');

        $blogs = BlogPost::where('is_active', true)
            ->when($search, function ($q) use ($search, $locale) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.{$locale}')) LIKE ?", ["%{$search}%"]);
            })
            ->when($tag, function ($q) use ($tag) {
                $q->whereHas('tags', fn($t) => $t->where('slug', $tag));
            })
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('frontend.blog.index', compact('locale', 'blogs', 'search', 'tag'));
    }

    public function show(string $locale, string $slug)
    {
        $post = BlogPost::with('tags')->where('is_active', true)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale}')) = ?", [$slug])
            ->firstOrFail();

        $recentPosts = BlogPost::where('is_active', true)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $hreflangUrls = [
            'az' => route('blog.show', ['az', $post->getTranslation('slug', 'az') ?: $post->getTranslation('slug', 'az')]),
            'en' => route('blog.show', ['en', $post->getTranslation('slug', 'en') ?: $post->getTranslation('slug', 'az')]),
            'ru' => route('blog.show', ['ru', $post->getTranslation('slug', 'ru') ?: $post->getTranslation('slug', 'az')]),
        ];

        return view('frontend.blog.show', compact('locale', 'post', 'recentPosts', 'hreflangUrls'));
    }
}
