<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('position')->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'position' => 'required|integer|in:1,2,3,4',
            'title' => 'nullable|string|max:255',
            'url' => 'nullable|url',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Using StorageHelper if available as seen in ProductController, 
            // otherwise fallback to standard storage. 
            // Assuming StorageHelper exists based on ProductController usage.
            // If StorageHelper isn't easily importable, I'll use standard Storage::putFile
            
            // To be safe and consistent with ProductController:
             $data['image'] = StorageHelper::uploadImage($request, 'image', 'banners', 'banner-'.time());
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', __('Banner created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not used
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'position' => 'required|integer|in:1,2,3,4',
            'title' => 'nullable|string|max:255',
            'url' => 'nullable|url',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = StorageHelper::uploadImage($request, 'image', 'banners', 'banner-'.time());
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', __('Banner updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', __('Banner deleted successfully'));
    }
}
