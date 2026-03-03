<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeCta;
use Illuminate\Http\Request;

class HomeCtaController extends Controller
{
    public function edit()
    {
        $cta = HomeCta::firstOrCreate([]);
        return view('admin.home_cta.form', compact('cta'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'       => 'nullable|array',
            'description' => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_url'  => 'nullable|string|max:255',
            'image'       => 'nullable|image|max:3072',
        ]);

        $cta = HomeCta::firstOrCreate([]);

        $data = [
            'title'       => $request->input('title', []),
            'description' => $request->input('description', []),
            'button_text' => $request->input('button_text', []),
            'button_url'  => $request->input('button_url'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('home', 'public');
        }

        $cta->update($data);

        return redirect()->route('admin.home-cta.edit')->with('success', 'CTA bölməsi yadda saxlanıldı.');
    }
}
