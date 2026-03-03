<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Box;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BoxController extends Controller
{
    public function index()
    {
        $boxes = Box::orderBy('order')->paginate(15);
        return view('admin.boxes.index', compact('boxes'));
    }

    public function create()
    {
        return view('admin.boxes.form', ['box' => new Box()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.az'          => 'required|string|max:255',
            'title'             => 'nullable|array',
            'slug'              => 'nullable|array',
            'category'          => 'nullable|array',
            'short_description' => 'nullable|array',
            'content'           => 'nullable|array',
            'meta_title'        => 'nullable|array',
            'meta_description'  => 'nullable|array',
            'meta_keywords'     => 'nullable|array',
            'cover_image'       => 'nullable|image|max:2048',
            'og_image'          => 'nullable|image|max:2048',
            'price'             => 'nullable|numeric|min:0',
            'order'             => 'nullable|integer',
        ]);

        $data = [
            'title'             => $request->input('title', []),
            'slug'              => $this->resolveSlug($request->input('slug', []), $request->input('title', [])),
            'category'          => $request->input('category', []),
            'short_description' => $request->input('short_description', []),
            'content'           => $request->input('content', []),
            'meta_title'        => $request->input('meta_title', []),
            'meta_description'  => $request->input('meta_description', []),
            'meta_keywords'     => $request->input('meta_keywords', []),
            'price'             => $request->input('price'),
            'order'             => $request->input('order', 0),
            'is_active'         => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('boxes', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        Box::create($data);
        return redirect()->route('admin.boxes.index')->with('success', 'Qutu əlavə edildi.');
    }

    public function edit(Box $box)
    {
        return view('admin.boxes.form', compact('box'));
    }

    public function update(Request $request, Box $box)
    {
        $request->validate([
            'title.az'          => 'required|string|max:255',
            'title'             => 'nullable|array',
            'slug'              => 'nullable|array',
            'category'          => 'nullable|array',
            'short_description' => 'nullable|array',
            'content'           => 'nullable|array',
            'meta_title'        => 'nullable|array',
            'meta_description'  => 'nullable|array',
            'meta_keywords'     => 'nullable|array',
            'cover_image'       => 'nullable|image|max:2048',
            'og_image'          => 'nullable|image|max:2048',
            'price'             => 'nullable|numeric|min:0',
            'order'             => 'nullable|integer',
        ]);

        $data = [
            'title'             => $request->input('title', []),
            'slug'              => $this->resolveSlug($request->input('slug', []), $request->input('title', []), $box->getTranslations('slug')),
            'category'          => $request->input('category', []),
            'short_description' => $request->input('short_description', []),
            'content'           => $request->input('content', []),
            'meta_title'        => $request->input('meta_title', []),
            'meta_description'  => $request->input('meta_description', []),
            'meta_keywords'     => $request->input('meta_keywords', []),
            'price'             => $request->input('price'),
            'order'             => $request->input('order', 0),
            'is_active'         => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('boxes', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $box->update($data);
        return redirect()->route('admin.boxes.index')->with('success', 'Qutu yeniləndi.');
    }

    public function destroy(Box $box)
    {
        $box->delete();
        return redirect()->route('admin.boxes.index')->with('success', 'Qutu silindi.');
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
