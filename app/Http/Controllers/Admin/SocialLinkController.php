<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $links = SocialLink::orderBy('order')->get();
        return view('admin.social_links.index', compact('links'));
    }

    public function create()
    {
        $link = new SocialLink();
        return view('admin.social_links.form', compact('link'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'url'  => 'required|string|max:500',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'url', 'order', 'is_active']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('social', 'public');
        }

        SocialLink::create($data);

        return redirect()->route('admin.social-links.index')->with('success', 'Sosial link əlavə edildi.');
    }

    public function edit(SocialLink $socialLink)
    {
        return view('admin.social_links.form', ['link' => $socialLink]);
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'url'  => 'required|string|max:500',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'url', 'order', 'is_active']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('social', 'public');
        }

        $socialLink->update($data);

        return redirect()->route('admin.social-links.index')->with('success', 'Sosial link yeniləndi.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        return back()->with('success', 'Silindi.');
    }
}
