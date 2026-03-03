<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.az'         => 'required|string|max:255',
            'image'            => 'nullable|image|max:4096',
            'og_image'         => 'nullable|image|max:2048',
            'order'            => 'nullable|integer',
            'step_img.*'       => 'nullable|image|max:4096',
            'gallery.*'        => 'nullable|image|max:4096',
        ]);

        $data = $this->buildData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('services/icons', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        // Gallery images
        $images = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $images[] = $file->store('services/gallery', 'public');
            }
        }
        $data['images'] = $images;

        // Steps images
        $steps = $this->buildSteps($request, []);
        $data['steps'] = $steps;

        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Xidmət əlavə edildi.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title.az'         => 'required|string|max:255',
            'image'            => 'nullable|image|max:4096',
            'og_image'         => 'nullable|image|max:2048',
            'order'            => 'nullable|integer',
            'step_img.*'       => 'nullable|image|max:4096',
            'gallery.*'        => 'nullable|image|max:4096',
        ]);

        $data = $this->buildData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('services/icons', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        // Gallery: keep existing + add new
        $existingImages = $service->images ?? [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $existingImages[] = $file->store('services/gallery', 'public');
            }
        }
        // Remove deleted images
        $keepImages = $request->input('keep_images', []);
        $existingImages = array_values(array_filter($existingImages, fn($img) => in_array($img, $keepImages)));
        $data['images'] = $existingImages;

        // Steps
        $data['steps'] = $this->buildSteps($request, $service->steps ?? []);

        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Xidmət yeniləndi.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Xidmət silindi.');
    }

    private function buildData(Request $request): array
    {
        // Build advantages structure: {az: [t1,t2,t3,t4], en: [...], ru: [...]}
        $advantages = [];
        foreach (['az', 'en', 'ru'] as $lang) {
            $advantages[$lang] = $request->input("adv.{$lang}", ['', '', '', '']);
        }

        return [
            'title'             => $request->input('title', []),
            'slug'              => $this->resolveSlug($request->input('slug', []), $request->input('title', [])),
            'short_description' => $request->input('short_description', []),
            'content'           => $request->input('content', []),
            'steps_title'       => $request->input('steps_title', []),
            'steps_subtitle'    => $request->input('steps_subtitle', []),
            'advantages'        => $advantages,
            'meta_title'        => $request->input('meta_title', []),
            'meta_description'  => $request->input('meta_description', []),
            'meta_keywords'     => $request->input('meta_keywords', []),
            'order'             => $request->input('order', 0),
            'is_active'         => $request->boolean('is_active'),
            'show_in_menu'      => $request->boolean('show_in_menu'),
        ];
    }

    private function buildSteps(Request $request, array $existingSteps): array
    {
        $steps = [];
        $stepData = $request->input('step', []);

        for ($i = 0; $i < 3; $i++) {
            $step = [
                'title'       => $stepData[$i]['title'] ?? [],
                'description' => $stepData[$i]['description'] ?? [],
                'image'       => $existingSteps[$i]['image'] ?? null,
            ];

            if ($request->hasFile("step_img.{$i}")) {
                $step['image'] = $request->file("step_img.{$i}")->store('services/steps', 'public');
            }

            $steps[] = $step;
        }

        return $steps;
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
