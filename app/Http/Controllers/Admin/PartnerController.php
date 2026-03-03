<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('order')->paginate(20);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.form', ['partner' => new Partner()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo'  => 'required|image|max:2048',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'name'      => '',
            'order'     => $request->input('order', 0),
            'is_active' => $request->boolean('is_active'),
            'logo'      => $request->file('logo')->store('partners', 'public'),
        ];

        Partner::create($data);
        return redirect()->route('admin.partners.index')->with('success', 'Tərəfdaş əlavə edildi.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'logo'  => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'order'     => $request->input('order', 0),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);
        return redirect()->route('admin.partners.index')->with('success', 'Tərəfdaş yeniləndi.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Tərəfdaş silindi.');
    }
}
