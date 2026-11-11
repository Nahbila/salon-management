<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', ['services' => $services]);
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'target_gender' => 'required|in:male,female',
            'image' => 'nullable|image|max:2048',
        ]);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service added.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', ['service' => $service]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'target_gender' => 'required|in:male,female',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }
    public function reactivate(Service $service)
    {
        $service->update(['is_active' => true]);
        return back()->with('success', 'Service reactivated.');
    }

    public function destroy(Service $service)
    {
    $service->update(['is_active' => false]);

    return back()->with('success', 'Service deactivated.');
    }
}