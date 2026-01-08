<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('position_references', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Kode unik posisi, contoh: DPD-KETUA');
            $table->string('name')->comment('Nama jabatan/posisi');
            $table->enum('organization_level', ['dpd', 'dpc', 'dprt', 'all'])->default('all');
            $table->enum('category', ['pimpinan', 'sekretariat', 'bendahara', 'bidang', 'departemen', 'anggota', 'lainnya'])->default('lainnya');
            $table->integer('order')->default(0);
            $table->text('description')->nullable();
            $table->json('responsibilities')->nullable()->comment('Tugas dan tanggung jawab');
            $table->boolean('is_required')->default(false)->comment('Posisi wajib ada di struktur');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_level', 'category', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('position_references');
    }
};
