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
        Schema::table('events', function (Blueprint $table) {
            // Add member_id (siapa yang create event)
            $table->unsignedBigInteger('member_id')->nullable()->after('id');
            $table->foreign('member_id')->references('id')->on('data_members')->onDelete('set null');
            
            // Add jumlah_peserta
            $table->integer('jumlah_peserta')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropColumn(['member_id', 'jumlah_peserta']);
        });
    }
};