<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kabupaten_geo', function (Blueprint $table) {
            $table->id();
            $table->string('kabupaten_name');
            $table->string('kode_bps')->unique();
            $table->json('geojson_data');
            $table->decimal('center_lat', 10, 8);
            $table->decimal('center_lng', 11, 8);
            $table->integer('total_kecamatan')->default(0);
            $table->integer('total_desa')->default(0);
            $table->timestamps();
        });

        Schema::create('kecamatan_geo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_id')->constrained('kabupaten_geo')->onDelete('cascade');
            $table->string('kecamatan_name');
            $table->string('kode_bps')->unique();
            $table->json('geojson_data');
            $table->decimal('center_lat', 10, 8);
            $table->decimal('center_lng', 11, 8);
            $table->integer('total_desa')->default(0);
            $table->timestamps();
        });

        Schema::create('desa_geo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('kecamatan_geo')->onDelete('cascade');
            $table->string('desa_name');
            $table->string('kode_bps')->unique();
            $table->json('geojson_data');
            $table->decimal('center_lat', 10, 8);
            $table->decimal('center_lng', 11, 8);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desa_geo');
        Schema::dropIfExists('kecamatan_geo');
        Schema::dropIfExists('kabupaten_geo');
    }
};