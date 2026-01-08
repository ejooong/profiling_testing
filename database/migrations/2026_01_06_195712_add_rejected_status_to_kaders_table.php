<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ubah tipe ENUM untuk kolom status
        DB::statement("ALTER TABLE kaders MODIFY COLUMN status ENUM('active', 'pending', 'rejected', 'non_active') DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE kaders MODIFY COLUMN status ENUM('active', 'pending', 'non_active') DEFAULT 'pending'");
    }
};
