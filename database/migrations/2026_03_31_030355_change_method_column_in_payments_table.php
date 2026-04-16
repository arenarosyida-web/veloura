<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom method dari ENUM ke VARCHAR
        // agar bisa simpan nilai dinamis dari Midtrans
        DB::statement("ALTER TABLE payments MODIFY COLUMN method VARCHAR(100) NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('cod','ewallet') NOT NULL");
    }
};