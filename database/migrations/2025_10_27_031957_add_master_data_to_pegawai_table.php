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
        Schema::table('pegawai', function (Blueprint $table) {
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans')->onDelete('set null');
            $table->foreignId('jenis_jabatan_id')->nullable()->constrained('jenis_jabatans')->onDelete('set null');
            $table->foreignId('jenjang_id')->nullable()->constrained('jenjangs')->onDelete('set null');
            $table->foreignId('golongan_id')->nullable()->constrained('golongans')->onDelete('set null');
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerja')->onDelete('set null');
            $table->foreignId('induk_unit_kerja_id')->nullable()->constrained('induk_unit_kerja')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['jabatan_id']);
            $table->dropColumn('jabatan_id');
            $table->dropForeign(['jenis_jabatan_id']);
            $table->dropColumn('jenis_jabatan_id');
            $table->dropForeign(['jenjang_id']);
            $table->dropColumn('jenjang_id');
            $table->dropForeign(['golongan_id']);
            $table->dropColumn('golongan_id');
            $table->dropForeign(['unit_kerja_id']);
            $table->dropColumn('unit_kerja_id');
            $table->dropForeign(['induk_unit_kerja_id']);
            $table->dropColumn('induk_unit_kerja_id');
        });
    }
};
