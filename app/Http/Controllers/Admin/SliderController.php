<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.form', ['slider' => new Slider()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'nullable|array',
            'subtitle'    => 'nullable|array',
            'button_text' => 'nullable|array',
            'image'       => 'required|image|max:4096',
            'button_url'  => 'nullable|string|max:255',
            'order'       => 'nullable|integer',
        ]);

        $data = [
            'title'       => $request->input('title', []),
            'subtitle'    => $request->input('subtitle', []),
            'button_text' => $request->input('button_text', []),
            'button_url'  => $request->input('button_url', ''),
            'order'       => $request->input('order', 0),
            'is_active'   => $request->boolean('is_active'),
            'image'       => $request->file('image')->store('sliders', 'public'),
        ];

        Slider::create($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider əlavə edildi.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title'       => 'nullable|array',
            'subtitle'    => 'nullable|array',
            'button_text' => 'nullable|array',
            'image'       => 'nullable|image|max:4096',
            'button_url'  => 'nullable|string|max:255',
            'order'       => 'nullable|integer',
        ]);

        $data = [
            'title'       => $request->input('title', []),
            'subtitle'    => $request->input('subtitle', []),
            'button_text' => $request->input('button_text', []),
            'button_url'  => $request->input('button_url', ''),
            'order'       => $request->input('order', 0),
            'is_active'   => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider yeniləndi.');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider silindi.');
    }
}
