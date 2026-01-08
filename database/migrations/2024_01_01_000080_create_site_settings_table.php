<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->string('type')->default('string'); // string, number, boolean, array, json
            $table->string('group')->default('general'); // general, appearance, seo, social, email
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('site_settings')->insert([
            [
                'key' => 'site_name',
                'value' => json_encode('NasDem Bojonegoro'),
                'type' => 'string',
                'group' => 'general',
                'description' => 'Nama website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_description',
                'value' => json_encode('Website Resmi Partai NasDem Kabupaten Bojonegoro'),
                'type' => 'string',
                'group' => 'general',
                'description' => 'Deskripsi website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_logo',
                'value' => json_encode(null),
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Logo website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_email',
                'value' => json_encode('info@nasdem-bojonegoro.id'),
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Email kontak utama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_phone',
                'value' => json_encode('(0353) 123456'),
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Telepon kontak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_address',
                'value' => json_encode('Jl. Raya Bojonegoro No. 123, Kabupaten Bojonegoro, Jawa Timur'),
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Alamat kantor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'facebook_url',
                'value' => json_encode('https://facebook.com/nasdembojonegoro'),
                'type' => 'string',
                'group' => 'social',
                'description' => 'URL Facebook',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'instagram_url',
                'value' => json_encode('https://instagram.com/nasdembojonegoro'),
                'type' => 'string',
                'group' => 'social',
                'description' => 'URL Instagram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'twitter_url',
                'value' => json_encode('https://twitter.com/nasdembojonegoro'),
                'type' => 'string',
                'group' => 'social',
                'description' => 'URL Twitter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'youtube_url',
                'value' => json_encode('https://youtube.com/nasdembojonegoro'),
                'type' => 'string',
                'group' => 'social',
                'description' => 'URL YouTube',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_mode',
                'value' => json_encode(false),
                'type' => 'boolean',
                'group' => 'general',
                'description' => 'Mode maintenance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};