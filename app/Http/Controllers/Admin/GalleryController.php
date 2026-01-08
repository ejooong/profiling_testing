<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasAnyRole(['super-admin', 'dpd-admin', 'news-writer'])) {
            abort(403, 'Unauthorized action.');
        }

        $galleries = Gallery::withCount('images')
            ->latest()
            ->paginate(10);

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        if (!auth()->user()->hasAnyRole(['super-admin', 'dpd-admin', 'news-writer'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('create-gallery')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:pelantikan,sosial,rapat,kunjungan,pelatihan,kerjasama,lainnya',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'participant_count' => 'nullable|integer|min:0',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
            'is_published' => 'boolean'
        ]);

        try {
            $gallery = Gallery::create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'description' => $validated['description'],
                'category' => $validated['category'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'],
                'location' => $validated['location'],
                'participant_count' => $validated['participant_count'],
                'is_published' => $request->boolean('is_published'),
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $this->storeImage($image);

                    GalleryImage::create([
                        'gallery_id' => $gallery->id,
                        'image_path' => $path,
                        'image_name' => $image->getClientOriginalName(),
                        'sort_order' => $index,
                        'caption' => $validated['captions'][$index] ?? null,
                    ]);
                }
            }

            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery berhasil dibuat dengan ' . count($request->file('images')) . ' foto.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Gallery $gallery)
    {
        if (!Gate::allows('view-gallery')) {
            abort(403, 'Unauthorized action.');
        }

        $gallery->load('images');
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        if (!Gate::allows('edit-gallery')) {
            abort(403, 'Unauthorized action.');
        }

        $gallery->load('images');
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        if (!Gate::allows('edit-gallery')) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi untuk update
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:pelantikan,sosial,rapat,kunjungan,pelatihan,kerjasama,lainnya',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'participant_count' => 'nullable|integer|min:0',
            'new_images' => 'nullable|array',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'new_captions' => 'nullable|array',
            'new_captions.*' => 'nullable|string|max:255',
            'existing_captions' => 'nullable|array',
            'existing_captions.*' => 'nullable|string|max:255',
            'is_published' => 'boolean'
        ]);

        try {
            // Update gallery data
            $gallery->update([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'description' => $validated['description'],
                'category' => $validated['category'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'],
                'location' => $validated['location'],
                'participant_count' => $validated['participant_count'],
                'is_published' => $request->boolean('is_published'),
            ]);

            // Update existing image captions
            if ($request->has('existing_captions')) {
                foreach ($request->input('existing_captions') as $imageId => $caption) {
                    GalleryImage::where('id', $imageId)
                        ->where('gallery_id', $gallery->id)
                        ->update(['caption' => $caption]);
                }
            }

            // Handle new image uploads
            if ($request->hasFile('new_images')) {
                $startOrder = $gallery->images()->max('sort_order') ?? 0;

                foreach ($request->file('new_images') as $index => $image) {
                    $path = $this->storeImage($image);

                    GalleryImage::create([
                        'gallery_id' => $gallery->id,
                        'image_path' => $path,
                        'image_name' => $image->getClientOriginalName(),
                        'sort_order' => $startOrder + $index + 1,
                        'caption' => $validated['new_captions'][$index] ?? null,
                    ]);
                }
            }

            // Validasi minimal ada satu gambar
            $totalImages = $gallery->images()->count();
            if ($totalImages === 0) {
                throw new \Exception('Gallery harus memiliki minimal 1 foto.');
            }

            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Gallery update error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Gallery $gallery)
    {
        if (!Gate::allows('delete-gallery')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete images from storage
            foreach ($gallery->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $gallery->delete();

            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteImage(GalleryImage $image)
    {
        if (!Gate::allows('edit-gallery')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Cek apakah ini satu-satunya gambar di gallery
            $gallery = $image->gallery;
            $imageCount = $gallery->images()->count();

            if ($imageCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus gambar terakhir. Gallery harus memiliki minimal 1 foto.'
                ], 400);
            }

            // Hapus file dari storage
            Storage::disk('public')->delete($image->image_path);

            // Hapus dari database
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            \Log::error('Delete image error:', [
                'error' => $e->getMessage(),
                'image_id' => $image->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reorderImages(Request $request, Gallery $gallery)
    {
        if (!Gate::allows('edit-gallery')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:gallery_images,id'
        ]);

        try {
            foreach ($request->order as $index => $imageId) {
                GalleryImage::where('id', $imageId)
                    ->where('gallery_id', $gallery->id)
                    ->update(['sort_order' => $index]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function togglePublish(Gallery $gallery)
    {
        if (!Gate::allows('edit-gallery')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $gallery->update(['is_published' => !$gallery->is_published]);

            return response()->json([
                'success' => true,
                'is_published' => $gallery->is_published,
                'message' => $gallery->is_published
                    ? 'Gallery telah dipublikasikan'
                    : 'Gallery telah disembunyikan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function storeImage($image)
    {
        // Buat folder berdasarkan tahun/bulan
        $year = date('Y');
        $month = date('m');
        $path = "galleries/{$year}/{$month}";

        // Buat folder jika belum ada
        Storage::disk('public')->makeDirectory($path);

        // Generate nama file unik
        $filename = Str::random(20) . '_' . time() . '.' . $image->getClientOriginalExtension();

        // Simpan gambar
        $image->storeAs($path, $filename, 'public');

        return "{$path}/{$filename}";
    }

    /**
     * Validasi tambahan untuk memastikan ada minimal 1 gambar
     */
    protected function validateGalleryHasImages(Gallery $gallery)
    {
        if ($gallery->images()->count() === 0) {
            return false;
        }
        return true;
    }
}
