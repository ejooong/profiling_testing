<?php

namespace App\Http\Controllers\Admin\Berita;

use App\Http\Controllers\Controller;
use App\Models\Berita\Berita;
use App\Models\Berita\BeritaCategory;
use App\Models\DPC\Dpc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with(['category', 'user', 'dpc'])
            ->latest()
            ->paginate(20);

        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        $categories = BeritaCategory::where('is_active', true)->get();
        $dpcs = Dpc::where('is_active', true)->get();
        return view('admin.berita.create', compact('categories', 'dpcs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:berita_categories,id',
            'dpc_id' => 'nullable|exists:dpc,id',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string|max:160',
            'is_featured' => 'boolean',
            'is_headline' => 'boolean',
            'status' => 'required|in:draft,published,archived',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('berita/images', 'public');
            $validated['featured_image'] = $path;
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if (!empty($validated['meta_keywords'])) {
            $validated['meta_keywords'] = explode(',', $validated['meta_keywords']);
        }

        Berita::create($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dibuat.');
    }

    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        $categories = BeritaCategory::where('is_active', true)->get();
        $dpcs = Dpc::where('is_active', true)->get();
        return view('admin.berita.edit', compact('berita', 'categories', 'dpcs'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:berita_categories,id',
            'dpc_id' => 'nullable|exists:dpc,id',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string|max:160',
            'is_featured' => 'sometimes|boolean',  // Ubah dari 'boolean' ke 'sometimes|boolean'
            'is_headline' => 'sometimes|boolean',  // Ubah dari 'boolean' ke 'sometimes|boolean'
            'status' => 'required|in:draft,published,archived',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Set default value jika checkbox tidak dicentang
        if (!isset($validated['is_featured'])) {
            $validated['is_featured'] = false;
        }

        if (!isset($validated['is_headline'])) {
            $validated['is_headline'] = false;
        }

        // Handle remove image checkbox
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($berita->featured_image) {
                \Storage::disk('public')->delete($berita->featured_image);
            }
            $validated['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama jika ada
            if ($berita->featured_image) {
                \Storage::disk('public')->delete($berita->featured_image);
            }

            $path = $request->file('featured_image')->store('berita/images', 'public');
            $validated['featured_image'] = $path;
        }

        if ($validated['status'] === 'published' && !$berita->published_at) {
            $validated['published_at'] = now();
        }

        if (!empty($validated['meta_keywords'])) {
            $validated['meta_keywords'] = explode(',', $validated['meta_keywords']);
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        // Hapus gambar jika ada
        if ($berita->featured_image) {
            \Storage::disk('public')->delete($berita->featured_image);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function publish(Berita $berita)
    {
        $berita->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dipublikasikan.');
    }
}
