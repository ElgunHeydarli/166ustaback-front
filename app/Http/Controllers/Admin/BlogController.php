<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::latest()->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $tags = BlogTag::orderBy('name')->get();
        return view('admin.blog.form', ['post' => new BlogPost(), 'tags' => $tags]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.az'         => 'required|string|max:255',
            'title'            => 'nullable|array',
            'slug'             => 'nullable|array',
            'excerpt'          => 'nullable|array',
            'content'          => 'nullable|array',
            'meta_title'       => 'nullable|array',
            'meta_description' => 'nullable|array',
            'meta_keywords'    => 'nullable|array',
            'image'            => 'nullable|image|max:2048',
            'og_image'         => 'nullable|image|max:2048',
            'published_at'     => 'nullable|date',
        ]);

        $data = [
            'title'            => $request->input('title', []),
            'slug'             => $this->resolveSlug($request->input('slug', []), $request->input('title', [])),
            'excerpt'          => $request->input('excerpt', []),
            'content'          => $request->input('content', []),
            'meta_title'       => $request->input('meta_title', []),
            'meta_description' => $request->input('meta_description', []),
            'meta_keywords'    => $request->input('meta_keywords', []),
            'published_at'     => $request->input('published_at') ?: now(),
            'is_active'        => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('blog', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $post = BlogPost::create($data);
        $post->tags()->sync($request->input('tags', []));
        return redirect()->route('admin.blog.index')->with('success', 'Bloq yazısı əlavə edildi.');
    }

    public function edit(BlogPost $blog)
    {
        $tags = BlogTag::orderBy('name')->get();
        return view('admin.blog.form', ['post' => $blog, 'tags' => $tags]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $request->validate([
            'title.az'         => 'required|string|max:255',
            'title'            => 'nullable|array',
            'slug'             => 'nullable|array',
            'excerpt'          => 'nullable|array',
            'content'          => 'nullable|array',
            'meta_title'       => 'nullable|array',
            'meta_description' => 'nullable|array',
            'meta_keywords'    => 'nullable|array',
            'image'            => 'nullable|image|max:2048',
            'og_image'         => 'nullable|image|max:2048',
            'published_at'     => 'nullable|date',
        ]);

        $data = [
            'title'            => $request->input('title', []),
            'slug'             => $this->resolveSlug($request->input('slug', []), $request->input('title', []), $blog->getTranslations('slug')),
            'excerpt'          => $request->input('excerpt', []),
            'content'          => $request->input('content', []),
            'meta_title'       => $request->input('meta_title', []),
            'meta_description' => $request->input('meta_description', []),
            'meta_keywords'    => $request->input('meta_keywords', []),
            'published_at'     => $request->input('published_at') ?: $blog->published_at,
            'is_active'        => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('blog', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $blog->update($data);
        $blog->tags()->sync($request->input('tags', []));
        return redirect()->route('admin.blog.index')->with('success', 'Bloq yazısı yeniləndi.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Bloq yazısı silindi.');
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
