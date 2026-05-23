<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * Display a listing of assets
     */
    public function index()
    {
        $assets = Asset::with(['category', 'creator'])
            ->latest()
            ->get();

        $categories = AssetCategory::all();

        return view('assets.index', compact('assets', 'categories'));
    }

    /**
     * Show form create
     */
    public function create()
    {
        $categories = AssetCategory::all();

        return view('assets.create', compact('categories'));
    }

    /**
     * Store new asset
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:asset_categories,id',
            'code' => 'required|unique:assets,code',
            'status' => 'required|in:normal,maintenance,broken',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Asset::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'code' => $request->code,
            'status' => $request->status,
            'location' => $request->location,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Asset successfully added');
    }

    /**
     * Show detail asset
     */
    public function show($id)
    {
        $asset = Asset::with([
            'category',
            'creator',
            'maintenanceLogs'
        ])->findOrFail($id);

        return view('assets.show', compact('asset'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $asset = Asset::findOrFail($id);

        $categories = AssetCategory::all();

        return view('assets.edit', compact('asset', 'categories'));
    }

    /**
     * Update asset
     */
    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:asset_categories,id',
            'code' => 'required|unique:assets,code,' . $id,
            'status' => 'required|in:normal,maintenance,broken',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $asset->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'code' => $request->code,
            'status' => $request->status,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('assets.index')
            ->with('success', 'Asset successfully updated');
    }

    /**
     * Delete asset
     */
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        $asset->delete();

        return redirect()
            ->route('assets.index')
            ->with('success', 'Asset successfully deleted');
    }
}