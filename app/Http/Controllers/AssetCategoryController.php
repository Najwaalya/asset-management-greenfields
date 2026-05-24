<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = AssetCategory::withCount('assets')
            ->latest()
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = AssetCategory::latest()->get();

        return view('categories.create', compact('categories'));
    }

    /**
     * Store new category
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories,name',
            'description' => 'nullable|string',
        ]);

        AssetCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Show category detail
     */
    public function show($id)
    {
        $category = AssetCategory::with('assets')->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $category = AssetCategory::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update category
     */
    public function update(Request $request, $id)
    {
        $category = AssetCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori asset berhasil diperbarui');
    }

    /**
     * Delete category
     */
    public function destroy($id)
    {
        $category = AssetCategory::findOrFail($id);

        // Optional safety check
        if ($category->assets()->count() > 0) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan asset');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori asset berhasil dihapus');
    }
}