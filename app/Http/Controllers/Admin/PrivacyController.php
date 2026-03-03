<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPage;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    public function edit()
    {
        $page = PrivacyPage::firstOrCreate([]);
        return view('admin.privacy.form', compact('page'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'nullable|array',
        ]);

        $page = PrivacyPage::firstOrCreate([]);
        $page->update(['content' => $request->input('content', [])]);

        return redirect()->route('admin.privacy.edit')->with('success', 'Məxfilik siyasəti yadda saxlanıldı.');
    }
}
