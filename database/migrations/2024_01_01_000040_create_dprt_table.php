<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dprt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dpc_id')->constrained('dpc')->onDelete('cascade');
            $table->string('desa_name');
            $table->string('slug')->unique();
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('ketua')->nullable();
            $table->integer('total_kader')->default(0);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('geojson_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('dprt_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dprt_id')->constrained('dprt')->onDelete('cascade');
            $table->string('position_name');
            $table->string('person_name');
            $table->string('person_photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('order')->default(0);
            $table->enum('level', ['pengurus', 'anggota']);
            $table->text('responsibilities')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dprt_structures');
        Schema::dropIfExists('dprt');
    }
};