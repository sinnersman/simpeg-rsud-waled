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
        Schema::table('jabatans', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_jabatan_id')->nullable()->after('jenjang_id');
            $table->foreign('parent_jabatan_id')->references('id')->on('jabatans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jabatans', function (Blueprint $table) {
            if (Schema::hasColumn('jabatans', 'parent_jabatan_id')) {
                $table->dropForeign(['parent_jabatan_id']);
                $table->dropColumn('parent_jabatan_id');
            }
        });
    }
};
