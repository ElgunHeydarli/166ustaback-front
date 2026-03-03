<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::withCount('posts')->orderBy('name')->paginate(20);
        return view('admin.blog_tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.blog_tags.form', ['tag' => new BlogTag]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:blog_tags,name']);
        BlogTag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('admin.blog-tags.index')->with('success', 'Tag əlavə edildi.');
    }

    public function edit(BlogTag $blogTag)
    {
        return view('admin.blog_tags.form', ['tag' => $blogTag]);
    }

    public function update(Request $request, BlogTag $blogTag)
    {
        $request->validate(['name' => 'required|string|max:100|unique:blog_tags,name,' . $blogTag->id]);
        $blogTag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('admin.blog-tags.index')->with('success', 'Tag yeniləndi.');
    }

    public function destroy(BlogTag $blogTag)
    {
        $blogTag->delete();
        return back()->with('success', 'Tag silindi.');
    }
}
