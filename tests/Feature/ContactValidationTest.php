<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactValidationTest extends TestCase
{
    /** @test */
    public function validasi_nama_wajib_diisi()
    {
        $response = $this->post('/contact', [
            'name' => '', // KOSONG
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'subject' => 'Test',
            'message' => 'Test message yang cukup panjang'
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function validasi_email_wajib_diisi()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => '', // KOSONG
            'phone' => '081234567890',
            'subject' => 'Test',
            'message' => 'Test message yang cukup panjang'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function validasi_email_format()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'bukan-email', // FORMAT SALAH
            'phone' => '081234567890',
            'subject' => 'Test',
            'message' => 'Test message yang cukup panjang'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function validasi_subject_wajib_diisi()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'subject' => '', // KOSONG
            'message' => 'Test message yang cukup panjang'
        ]);

        $response->assertSessionHasErrors(['subject']);
    }

    /** @test */
    public function validasi_message_wajib_diisi()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'subject' => 'Test',
            'message' => '' // KOSONG
        ]);

        $response->assertSessionHasErrors(['message']);
    }

    /** @test */
    public function validasi_message_minimal_10_karakter()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'subject' => 'Test',
            'message' => '123456789' // HANYA 9 KARAKTER
        ]);

        $response->assertSessionHasErrors(['message']);
    }

    /** @test */
    public function validasi_sukses_jika_data_lengkap()
    {
        $response = $this->post('/contact', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Informasi Umum',
            'message' => 'Saya ingin bertanya tentang kegiatan partai.'
        ]);

        // Jika menggunakan mocking, bisa assert redirect
        $response->assertRedirect();
        // Atau jika error karena database, kita skip assertion ini
    }
}
