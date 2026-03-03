<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeWhyUs;
use Illuminate\Http\Request;

class HomeWhyUsController extends Controller
{
    public function edit()
    {
        $whyUs = HomeWhyUs::firstOrCreate([]);
        return view('admin.home_why_us.form', compact('whyUs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'          => 'nullable|array',
            'subtitle'       => 'nullable|array',
            'item_img.*'     => 'nullable|image|max:3072',
        ]);

        $whyUs = HomeWhyUs::firstOrCreate([]);
        $existingItems = $whyUs->items ?? [];

        $data = [
            'title'    => $request->input('title', []),
            'subtitle' => $request->input('subtitle', []),
        ];

        // Build items (fixed 4 slots)
        $items = [];
        for ($i = 0; $i < 4; $i++) {
            $item = [
                'title'       => $request->input("item_title.{$i}", []),
                'description' => $request->input("item_desc.{$i}", []),
                'image'       => $existingItems[$i]['image'] ?? null,
            ];

            if ($request->hasFile("item_img.{$i}")) {
                $item['image'] = $request->file("item_img.{$i}")->store('about/why_us', 'public');
            }

            $items[] = $item;
        }

        $data['items'] = $items;
        $whyUs->update($data);

        return redirect()->route('admin.home-why-us.edit')->with('success', '"Niyə Biz" bölməsi yadda saxlanıldı.');
    }
}
