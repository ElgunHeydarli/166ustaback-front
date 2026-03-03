<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::with('service')->orderBy('order')->paginate(15);
        return view('admin.portfolio.index', compact('items'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->orderBy('order')->get()->mapWithKeys(fn($s) => [$s->id => $s->getTranslation('title', 'az')]);
        return view('admin.portfolio.form', ['item' => new PortfolioItem(), 'services' => $services]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.az'          => 'required|string|max:255',
            'title'             => 'nullable|array',
            'slug'              => 'nullable|array',
            'short_description' => 'nullable|array',
            'content'           => 'nullable|array',
            'meta_title'        => 'nullable|array',
            'meta_description'  => 'nullable|array',
            'meta_keywords'     => 'nullable|array',
            'cover_image'       => 'nullable|image|max:2048',
            'og_image'          => 'nullable|image|max:2048',
            'gallery.*'         => 'nullable|image|max:4096',
            'service_id'        => 'nullable|exists:services,id',
            'order'             => 'nullable|integer',
            'client'            => 'nullable|string|max:255',
            'duration'          => 'nullable|string|max:255',
        ]);

        $data = [
            'title'             => $request->input('title', []),
            'slug'              => $this->resolveSlug($request->input('slug', []), $request->input('title', [])),
            'short_description' => $request->input('short_description', []),
            'content'           => $request->input('content', []),
            'meta_title'        => $request->input('meta_title', []),
            'meta_description'  => $request->input('meta_description', []),
            'meta_keywords'     => $request->input('meta_keywords', []),
            'service_id'        => $request->input('service_id'),
            'order'             => $request->input('order', 0),
            'is_active'         => $request->boolean('is_active'),
            'client'            => $request->input('client'),
            'duration'          => $request->input('duration'),
            'gallery'           => [],
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('portfolio', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $data['gallery'][] = $file->store('portfolio/gallery', 'public');
            }
        }

        PortfolioItem::create($data);
        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio əlavə edildi.');
    }

    public function edit(PortfolioItem $portfolio)
    {
        $services = Service::where('is_active', true)->orderBy('order')->get()->mapWithKeys(fn($s) => [$s->id => $s->getTranslation('title', 'az')]);
        return view('admin.portfolio.form', ['item' => $portfolio, 'services' => $services]);
    }

    public function update(Request $request, PortfolioItem $portfolio)
    {
        $request->validate([
            'title.az'          => 'required|string|max:255',
            'title'             => 'nullable|array',
            'slug'              => 'nullable|array',
            'short_description' => 'nullable|array',
            'content'           => 'nullable|array',
            'meta_title'        => 'nullable|array',
            'meta_description'  => 'nullable|array',
            'meta_keywords'     => 'nullable|array',
            'cover_image'       => 'nullable|image|max:2048',
            'og_image'          => 'nullable|image|max:2048',
            'gallery.*'         => 'nullable|image|max:4096',
            'service_id'        => 'nullable|exists:services,id',
            'order'             => 'nullable|integer',
            'client'            => 'nullable|string|max:255',
            'duration'          => 'nullable|string|max:255',
        ]);

        $data = [
            'title'             => $request->input('title', []),
            'slug'              => $this->resolveSlug($request->input('slug', []), $request->input('title', []), $portfolio->getTranslations('slug')),
            'short_description' => $request->input('short_description', []),
            'content'           => $request->input('content', []),
            'meta_title'        => $request->input('meta_title', []),
            'meta_description'  => $request->input('meta_description', []),
            'meta_keywords'     => $request->input('meta_keywords', []),
            'service_id'        => $request->input('service_id'),
            'order'             => $request->input('order', 0),
            'is_active'         => $request->boolean('is_active'),
            'client'            => $request->input('client'),
            'duration'          => $request->input('duration'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('portfolio', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        // Keep existing gallery + append new uploads; remove individually checked ones
        $existingGallery = $portfolio->gallery ?? [];
        $keepGallery = $request->input('keep_gallery', []);
        $existingGallery = array_values(array_filter($existingGallery, fn($p) => in_array($p, $keepGallery)));
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $existingGallery[] = $file->store('portfolio/gallery', 'public');
            }
        }
        $data['gallery'] = $existingGallery;

        $portfolio->update($data);
        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio yeniləndi.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        $portfolio->delete();
        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio silindi.');
    }

    private function resolveSlug(array $slugInput, array $titleInput, array $existing = []): array
    {
        $result = [];
        foreach (['az', 'en', 'ru'] as $lang) {
            if (!empty($slugInput[$lang])) {
                $result[$lang] = Str::slug($slugInput[$lang]);
            } elseif (!empty($existing[$lang])) {
                $result[$lang] = $existing[$lang];
            } else {
                $base = $titleInput[$lang] ?? $titleInput['az'] ?? '';
                $result[$lang] = Str::slug($base);
            }
        }
        return $result;
    }
}
