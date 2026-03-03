<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeAbout;
use Illuminate\Http\Request;

class HomeAboutController extends Controller
{
    public function edit()
    {
        $about = HomeAbout::firstOrCreate([]);
        return view('admin.home_about.form', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'       => 'nullable|array',
            'content'     => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_url'  => 'nullable|string|max:255',
            'image1'      => 'nullable|image|max:3072',
            'image2'      => 'nullable|image|max:3072',
        ]);

        $about = HomeAbout::firstOrCreate([]);

        $data = [
            'title'       => $request->input('title', []),
            'content'     => $request->input('content', []),
            'button_text' => $request->input('button_text', []),
            'button_url'  => $request->input('button_url'),
        ];

        if ($request->hasFile('image1')) {
            $data['image1'] = $request->file('image1')->store('about', 'public');
        }
        if ($request->hasFile('image2')) {
            $data['image2'] = $request->file('image2')->store('about', 'public');
        }

        $about->update($data);

        return redirect()->route('admin.home-about.edit')->with('success', 'Haqqımızda bölməsi yadda saxlanıldı.');
    }
}
