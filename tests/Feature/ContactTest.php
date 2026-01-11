<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\View;
use App\Models\Berita\Berita;
use App\Models\Berita\BeritaCategory;
use App\Models\Gallery;

class ContactTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // MOCK SEMUA QUERY DARI AppServiceProvider
        $this->mockAppServiceProvider();
    }
    
    private function mockAppServiceProvider()
    {
        // Mock Berita::published() query
        $beritaMock = Mockery::mock('overload:' . Berita::class);
        $beritaMock->shouldReceive('published')->andReturnSelf();
        $beritaMock->shouldReceive('orderBy')->andReturnSelf();
        $beritaMock->shouldReceive('take')->andReturnSelf();
        $beritaMock->shouldReceive('get')->andReturn(collect([])); // Return empty collection
        
        // Mock BeritaCategory query
        $categoryMock = Mockery::mock('overload:' . BeritaCategory::class);
        $categoryMock->shouldReceive('where')->andReturnSelf();
        $categoryMock->shouldReceive('get')->andReturn(collect([]));
        
        // Mock Gallery query
        $galleryMock = Mockery::mock('overload:' . Gallery::class);
        $galleryMock->shouldReceive('where')->andReturnSelf();
        $galleryMock->shouldReceive('withCount')->andReturnSelf();
        $galleryMock->shouldReceive('orderBy')->andReturnSelf();
        $galleryMock->shouldReceive('take')->andReturnSelf();
        $galleryMock->shouldReceive('get')->andReturn(collect([]));
        
        // Mock DB query untuk gallery stats
        \DB::shouldReceive('table')->with('gallery_images')->andReturnSelf();
        \DB::shouldReceive('join')->andReturnSelf();
        \DB::shouldReceive('where')->andReturnSelf();
        \DB::shouldReceive('count')->andReturn(0);
    }

    /** @test */
    public function halaman_kontak_bisa_diakses()
    {
        $response = $this->get('/contact');
        
        $response->assertStatus(200);
        $response->assertSee('Hubungi Kami');
        $response->assertSee('Kirim Pesan');
    }

    /** @test */
    public function validasi_form_berjalan_baik()
    {
        // Test validasi TANPA menyimpan ke database
        $response = $this->post('/contact', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Informasi Umum',
            'message' => 'Test message'
        ]);
        
        // Cek redirect (berarti form diproses)
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
    
    /** @test */
    public function validasi_error_jika_nama_kosong()
    {
        $response = $this->post('/contact', [
            'name' => '', // KOSONG - harus error
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Informasi Umum',
            'message' => 'Test message'
        ]);
        
        $response->assertSessionHasErrors(['name']);
    }
}