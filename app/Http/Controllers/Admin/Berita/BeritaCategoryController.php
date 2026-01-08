<?php

namespace App\Http\Controllers\Admin\Berita;

use App\Http\Controllers\Controller;
use App\Models\Berita\BeritaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaCategoryController extends Controller
{
    public function index()
    {
        $categories = BeritaCategory::withCount([
            'beritas as berita_count',
            'beritas as featured_berita_count' => fn($query) => $query->where('is_featured', true)
        ])
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(20);

        $totalCategories = BeritaCategory::count();
        $activeCategories = BeritaCategory::where('is_active', true)->count();
        $totalBerita = \App\Models\Berita\Berita::count();
        $featuredCategories = $totalCategories;

        return view('admin.berita.categories.index', compact(
            'categories',
            'totalCategories',
            'activeCategories',
            'totalBerita',
            'featuredCategories'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:berita_categories,name',
            'color' => 'nullable|string|max:7',
            'color_hex' => 'nullable|string|max:7',
            'order' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        // Gunakan color_hex jika ada, jika tidak gunakan color
        if (!empty($validated['color_hex'])) {
            $validated['color'] = $validated['color_hex'];
        }

        // Jika tidak ada warna, beri default
        if (empty($validated['color'])) {
            $validated['color'] = '#001F3F'; // Default blue
        }

        // Pastikan format hex benar (diawali #)
        if (!str_starts_with($validated['color'], '#')) {
            $validated['color'] = '#' . ltrim($validated['color'], '#');
        }

        $validated['slug'] = Str::slug($validated['name']);

        // Default is_active jika tidak ada
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        BeritaCategory::create($validated);

        return redirect()->route('admin.berita.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, BeritaCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:berita_categories,name,' . $category->id,
            'color' => 'nullable|string|max:7',
            'color_hex' => 'nullable|string|max:7',
            'order' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        // Gunakan color_hex jika ada, jika tidak gunakan color
        if (!empty($validated['color_hex'])) {
            $validated['color'] = $validated['color_hex'];
        }

        // Jika tidak ada warna, gunakan warna lama
        if (empty($validated['color'])) {
            $validated['color'] = $category->color;
        }

        // Pastikan format hex benar (diawali #)
        if (!str_starts_with($validated['color'], '#')) {
            $validated['color'] = '#' . ltrim($validated['color'], '#');
        }

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.berita.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(BeritaCategory $category)
    {
        // Cek apakah kategori digunakan oleh berita
        if ($category->beritas()->count() > 0) {
            return redirect()->route('admin.berita.categories.index')
                ->with('error', 'Tidak dapat menghapus kategori yang masih digunakan oleh berita.');
        }

        $category->delete();

        return redirect()->route('admin.berita.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    public function create()
    {
        return view('admin.berita.categories.create');
    }

    public function edit(BeritaCategory $category)
    {
        // Load beritas count untuk edit view
        $category->loadCount('beritas');

        return view('admin.berita.categories.edit', compact('category'));
    }
}
