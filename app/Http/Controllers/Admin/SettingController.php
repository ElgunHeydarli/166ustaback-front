<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name.az' => 'required|string|max:255',
            'phone'        => 'required|string|max:50',
            'email'        => 'required|email|max:255',
        ]);

        // Translatable keys — stored as JSON {"az":"...","en":"...","ru":"..."}
        $translatableKeys = ['site_name', 'site_tagline', 'meta_title', 'meta_description', 'meta_keywords'];
        foreach ($translatableKeys as $key) {
            $val = $request->input($key, []);
            if (is_array($val)) {
                Setting::set($key, json_encode($val, JSON_UNESCAPED_UNICODE));
            } else {
                Setting::set($key, $val);
            }
        }

        // Plain keys
        $plainKeys = [
            'phone', 'phone2', 'whatsapp', 'email', 'address', 'working_hours',
            'map_embed',
            'google_analytics', 'google_tag_manager', 'google_verification', 'robots_txt',
        ];
        foreach ($plainKeys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        if ($request->hasFile('site_logo')) {
            Setting::set('site_logo', $request->file('site_logo')->store('settings', 'public'));
        }
        if ($request->hasFile('site_favicon')) {
            Setting::set('site_favicon', $request->file('site_favicon')->store('settings', 'public'));
        }
        if ($request->hasFile('og_image')) {
            Setting::set('og_image', $request->file('og_image')->store('seo', 'public'));
        }

        return redirect()->route('admin.settings.index')->with('success', 'Parametrlər yadda saxlanıldı.');
    }
}
