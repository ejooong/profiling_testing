<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dpd_structures', function (Blueprint $table) {
            // Tambahkan field untuk struktur DPD utama
            $table->date('periode_mulai')->nullable()->after('is_active');
            $table->date('periode_selesai')->nullable()->after('periode_mulai');
            
            // Field untuk pimpinan utama
            $table->string('ketua')->nullable()->after('periode_selesai');
            $table->string('sekretaris')->nullable()->after('ketua');
            $table->string('bendahara')->nullable()->after('sekretaris');
            
            // Field untuk foto pimpinan
            $table->string('ketua_photo')->nullable()->after('bendahara');
            $table->string('sekretaris_photo')->nullable()->after('ketua_photo');
            $table->string('bendahara_photo')->nullable()->after('sekretaris_photo');
            
            // Field untuk struktur organisasi (JSON)
            $table->json('departemen')->nullable()->after('bendahara_photo');
            $table->json('panitia')->nullable()->after('departemen');
            
            // Field untuk visi, misi, catatan
            $table->text('visi')->nullable()->after('panitia');
            $table->text('misi')->nullable()->after('visi');
            $table->text('catatan')->nullable()->after('misi');
            
            // Ubah nama kolom person_photo menjadi ketua_photo (opsional)
            // $table->renameColumn('person_photo', 'ketua_photo');
            
            // Untuk backward compatibility, biarkan person_photo tetap ada
            // Tapi kita akan rename di controller jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dpd_structures', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            $table->dropColumn([
                'periode_mulai',
                'periode_selesai',
                'ketua',
                'sekretaris',
                'bendahara',
                'ketua_photo',
                'sekretaris_photo',
                'bendahara_photo',
                'departemen',
                'panitia',
                'visi',
                'misi',
                'catatan'
            ]);
        });
    }
};