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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();

            // Data Diri Pegawai
            $table->string('foto_pegawai')->nullable();
            $table->string('nip')->unique();
            $table->string('nip_lama')->nullable();
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin')->nullable();
            $table->string('agama')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('status_kepegawaian')->nullable();

            // Data Alamat Pegawai
            $table->string('suku')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('fax')->nullable();
            $table->string('telephone')->nullable();
            $table->string('handphone')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kebangsaan')->nullable();

            // Keterangan Badan
            $table->integer('berat_badan')->nullable();
            $table->integer('tinggi_badan')->nullable();

            // Keterangan Tambahan
            $table->string('no_karpeg')->nullable();
            $table->string('no_askes_bpjs')->nullable();
            $table->string('no_taspen')->nullable();
            $table->string('no_karis_karsu')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('no_korpri')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
