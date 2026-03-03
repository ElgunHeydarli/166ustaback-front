<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(15);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.form', ['campaign' => new Campaign()]);
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
            'starts_at'         => 'nullable|date',
            'ends_at'           => 'nullable|date|after_or_equal:starts_at',
        ]);

        $data = [
            'title'             => $request->input('title', []),
            'slug'              => $this->resolveSlug($request->input('slug', []), $request->input('title', [])),
            'short_description' => $request->input('short_description', []),
            'content'           => $request->input('content', []),
            'meta_title'        => $request->input('meta_title', []),
            'meta_description'  => $request->input('meta_description', []),
            'meta_keywords'     => $request->input('meta_keywords', []),
            'starts_at'         => $request->input('starts_at'),
            'ends_at'           => $request->input('ends_at'),
            'is_active'         => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('campaigns', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        Campaign::create($data);
        return redirect()->route('admin.campaigns.index')->with('success', 'Kampaniya əlavə edildi.');
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.form', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
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
            'starts_at'         => 'nullable|date',
            'ends_at'           => 'nullable|date|after_or_equal:starts_at',
        ]);

        $data = [
            'title'             => $request->input('title', []),
            'slug'              => $this->resolveSlug($request->input('slug', []), $request->input('title', []), $campaign->getTranslations('slug')),
            'short_description' => $request->input('short_description', []),
            'content'           => $request->input('content', []),
            'meta_title'        => $request->input('meta_title', []),
            'meta_description'  => $request->input('meta_description', []),
            'meta_keywords'     => $request->input('meta_keywords', []),
            'starts_at'         => $request->input('starts_at'),
            'ends_at'           => $request->input('ends_at'),
            'is_active'         => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('campaigns', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $campaign->update($data);
        return redirect()->route('admin.campaigns.index')->with('success', 'Kampaniya yeniləndi.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('admin.campaigns.index')->with('success', 'Kampaniya silindi.');
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
