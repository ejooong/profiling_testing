<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dpc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dpd_id')->constrained('dpd')->onDelete('cascade');
            $table->string('kecamatan_name');
            $table->string('slug')->unique();
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->string('ketua')->nullable();
            $table->string('sekretaris')->nullable();
            $table->string('bendahara')->nullable();
            $table->integer('total_kader')->default(0);
            $table->integer('total_dprt')->default(0);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('geojson_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('dpc_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dpc_id')->constrained('dpc')->onDelete('cascade');
            $table->string('position_name');
            $table->string('person_name');
            $table->string('person_photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('order')->default(0);
            $table->enum('level', ['pengurus', 'bpo', 'departemen']);
            $table->text('responsibilities')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dpc_structures');
        Schema::dropIfExists('dpc');
    }
};