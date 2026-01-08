<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kaders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('dpc_id')->constrained('dpc')->onDelete('cascade');
            $table->foreignId('dprt_id')->constrained('dprt')->onDelete('cascade');
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->text('address');
            $table->string('rt');
            $table->string('rw');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('profession');
            $table->string('education');
            $table->string('photo_path')->nullable();
            $table->enum('status', ['active', 'pending', 'non_active'])->default('pending');
            $table->date('join_date');
            $table->text('skills')->nullable();
            $table->string('position_in_party')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->dateTime('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kaders');
    }
};