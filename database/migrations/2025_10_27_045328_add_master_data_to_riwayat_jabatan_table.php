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
        Schema::table('riwayat_jabatan', function (Blueprint $table) {
            $table->foreignId('jenis_jabatan_id')->nullable()->constrained('jenis_jabatans')->onDelete('set null');
            $table->foreignId('jenjang_id')->nullable()->constrained('jenjangs')->onDelete('set null');
            $table->foreignId('golongan_id')->nullable()->constrained('golongans')->onDelete('set null');
            $table->date('tanggal_keluar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_jabatan', function (Blueprint $table) {
            $table->dropForeign(['jenis_jabatan_id']);
            $table->dropColumn('jenis_jabatan_id');
            $table->dropForeign(['jenjang_id']);
            $table->dropColumn('jenjang_id');
            $table->dropForeign(['golongan_id']);
            $table->dropColumn('golongan_id');
            $table->dropColumn('tanggal_keluar');
        });
    }
};
