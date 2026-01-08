<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_structures', function (Blueprint $table) {
            $table->id();
            $table->string('organization_type')->comment('dpd, dpc, dprt');
            $table->unsignedBigInteger('organization_id')->comment('ID dari DPD, DPC, atau DPRT');
            $table->foreignId('position_id')->constrained('position_references')->onDelete('cascade');

            // Data orang yang menjabat (bisa dari kader atau external)
            $table->foreignId('kader_id')->nullable()->constrained('kaders')->onDelete('set null');
            $table->string('external_name')->nullable()->comment('Nama jika bukan kader');
            $table->string('external_photo')->nullable();
            $table->string('external_phone')->nullable();
            $table->string('external_email')->nullable();

            // Periode jabatan
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();

            // Urutan tampilan
            $table->integer('order')->default(0);

            // Status
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index untuk performa query
            $table->index(['organization_type', 'organization_id', 'is_active'], 'org_structure_type_id_active_idx');
            $table->index(['kader_id', 'is_active']);
        });

        // Tambah kolom untuk backward compatibility di tabel existing
        Schema::table('dpd_structures', function (Blueprint $table) {
            $table->foreignId('position_reference_id')->nullable()->after('id')->constrained('position_references')->onDelete('set null');
            $table->foreignId('kader_id')->nullable()->after('position_reference_id')->constrained('kaders')->onDelete('set null');
        });

        Schema::table('dpc_structures', function (Blueprint $table) {
            $table->foreignId('position_reference_id')->nullable()->after('id')->constrained('position_references')->onDelete('set null');
            $table->foreignId('kader_id')->nullable()->after('position_reference_id')->constrained('kaders')->onDelete('set null');
        });

        Schema::table('dprt_structures', function (Blueprint $table) {
            $table->foreignId('position_reference_id')->nullable()->after('id')->constrained('position_references')->onDelete('set null');
            $table->foreignId('kader_id')->nullable()->after('position_reference_id')->constrained('kaders')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Hapus foreign key dan kolom dari tabel lama
        Schema::table('dprt_structures', function (Blueprint $table) {
            $table->dropForeign(['position_reference_id']);
            $table->dropForeign(['kader_id']);
            $table->dropColumn(['position_reference_id', 'kader_id']);
        });

        Schema::table('dpc_structures', function (Blueprint $table) {
            $table->dropForeign(['position_reference_id']);
            $table->dropForeign(['kader_id']);
            $table->dropColumn(['position_reference_id', 'kader_id']);
        });

        Schema::table('dpd_structures', function (Blueprint $table) {
            $table->dropForeign(['position_reference_id']);
            $table->dropForeign(['kader_id']);
            $table->dropColumn(['position_reference_id', 'kader_id']);
        });

        Schema::dropIfExists('organization_structures');
    }
};
