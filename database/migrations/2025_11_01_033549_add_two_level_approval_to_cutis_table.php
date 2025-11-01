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
        Schema::table('cutis', function (Blueprint $table) {
            $table->unsignedBigInteger('approver_1_id')->nullable()->after('status');
            $table->timestamp('approval_1_date')->nullable()->after('approver_1_id');
            $table->string('approval_1_status')->default('pending')->after('approval_1_date');
            $table->unsignedBigInteger('approver_2_id')->nullable()->after('approval_1_status');
            $table->timestamp('approval_2_date')->nullable()->after('approver_2_id');
            $table->string('approval_2_status')->default('pending')->after('approval_2_date');

            $table->foreign('approver_1_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approver_2_id')->references('id')->on('users')->onDelete('set null');

            // Drop old columns if they exist
            $table->dropColumn(['approver_id', 'approval_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cutis', function (Blueprint $table) {
            $table->dropForeign(['approver_1_id']);
            $table->dropForeign(['approver_2_id']);
            $table->dropColumn(['approver_1_id', 'approval_1_date', 'approval_1_status', 'approver_2_id', 'approval_2_date', 'approval_2_status']);

            // Re-add old columns if they were dropped
            $table->unsignedBigInteger('approver_id')->nullable()->after('status');
            $table->timestamp('approval_date')->nullable()->after('approver_id');
        });
    }
};
