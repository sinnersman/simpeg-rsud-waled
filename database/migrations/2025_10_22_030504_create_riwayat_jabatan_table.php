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
        Schema::create('riwayat_jabatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->foreignId('jabatan_id')->constrained('jabatans')->onDelete('cascade');
            $table->foreignId('unit_kerja_id')->constrained('unit_kerja')->onDelete('cascade');
            $table->foreignId('induk_unit_kerja_id')->constrained('induk_unit_kerja')->onDelete('cascade');
            $table->string('jenis_jabatan')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tmt')->nullable();
            $table->string('jenis_pns')->nullable();
            $table->string('no_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->string('pejabat_penetap')->nullable();
            $table->string('status_sumpah')->nullable();
            $table->string('no_pelantikan')->nullable();
            $table->date('tanggal_pelantikan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatan');
    }
};
