<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('service')->orderBy('order')->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->orderBy('order')->get()
            ->mapWithKeys(fn($s) => [$s->id => $s->getTranslation('title', 'az')]);
        return view('admin.testimonials.form', ['testimonial' => new Testimonial(), 'services' => $services]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'position'         => 'nullable|array',
            'review_text'      => 'nullable|array',
            'review_text.az'   => 'required|string',
            'rating'           => 'nullable|integer|min:1|max:5',
            'service_id'       => 'nullable|exists:services,id',
            'order'            => 'nullable|integer',
            'photo'            => 'nullable|image|max:2048',
        ]);

        $data = [
            'customer_name' => $request->input('customer_name'),
            'position'      => $request->input('position', []),
            'review_text'   => $request->input('review_text', []),
            'rating'        => $request->input('rating', 5),
            'service_id'    => $request->input('service_id'),
            'order'         => $request->input('order', 0),
            'is_active'     => $request->boolean('is_active'),
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Rəy əlavə edildi.');
    }

    public function edit(Testimonial $testimonial)
    {
        $services = Service::where('is_active', true)->orderBy('order')->get()
            ->mapWithKeys(fn($s) => [$s->id => $s->getTranslation('title', 'az')]);
        return view('admin.testimonials.form', compact('testimonial', 'services'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'position'         => 'nullable|array',
            'review_text'      => 'nullable|array',
            'review_text.az'   => 'required|string',
            'rating'           => 'nullable|integer|min:1|max:5',
            'service_id'       => 'nullable|exists:services,id',
            'order'            => 'nullable|integer',
            'photo'            => 'nullable|image|max:2048',
        ]);

        $data = [
            'customer_name' => $request->input('customer_name'),
            'position'      => $request->input('position', []),
            'review_text'   => $request->input('review_text', []),
            'rating'        => $request->input('rating', 5),
            'service_id'    => $request->input('service_id'),
            'order'         => $request->input('order', 0),
            'is_active'     => $request->boolean('is_active'),
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Rəy yeniləndi.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Rəy silindi.');
    }
}
