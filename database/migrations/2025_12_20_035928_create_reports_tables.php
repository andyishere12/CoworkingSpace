<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ==========================================
        // ATTENDANCE REPORTS - DI-COMMENT DULU
        // ==========================================
        // Aktifkan nanti kalau fitur attendance sudah jadi
        /*
        Schema::create('attendance_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->date('attendance_date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha', 'terlambat'])->default('hadir');
            $table->integer('duration_minutes')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('member_id')->references('id')->on('data_members')->onDelete('cascade');
            $table->index(['attendance_date', 'member_id']);
        });
        */

        // ==========================================
        // MEMBERSHIP REPORTS - AKTIF
        // ==========================================
        Schema::create('membership_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('membership_type'); // reguler, premium, vip
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_days')->default(0);
            $table->enum('status', ['active', 'expired', 'suspended', 'cancelled'])->default('active');
            $table->decimal('membership_fee', 10, 2)->default(0);
            $table->timestamps();
            
            // SUDAH DISESUAIKAN: data_members (bukan members)
            $table->foreign('member_id')->references('id')->on('data_members')->onDelete('cascade');
        });

        // ==========================================
        // ROOM USAGE REPORTS - AKTIF
        // ==========================================
        Schema::create('room_usage_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->date('usage_date');
            $table->integer('total_bookings')->default(0);
            $table->integer('total_hours_used')->default(0);
            $table->integer('total_participants')->default(0);
            $table->decimal('revenue_generated', 10, 2)->default(0);
            $table->enum('peak_time', ['morning', 'afternoon', 'evening', 'night'])->nullable();
            $table->timestamps();
            
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->index(['usage_date', 'room_id']);
        });

        // ==========================================
        // EVENT REPORTS - AKTIF
        // ==========================================
        Schema::create('event_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->date('event_date');
            $table->integer('registered_participants')->default(0);
            $table->integer('actual_attendees')->default(0);
            $table->integer('attendance_rate')->default(0); // persentase kehadiran
            $table->decimal('revenue', 10, 2)->default(0);
            $table->decimal('expenses', 10, 2)->default(0);
            $table->decimal('profit', 10, 2)->default(0);
            $table->enum('event_status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->text('feedback_summary')->nullable();
            $table->decimal('rating', 3, 2)->default(0); // rating 0-5
            $table->timestamps();
            
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });

        // ==========================================
        // MONTHLY SUMMARY REPORTS - AKTIF (OPSIONAL)
        // ==========================================
        // Bisa di-comment juga kalau tidak perlu
        Schema::create('monthly_summary_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('month');
            $table->integer('total_members')->default(0);
            $table->integer('new_members')->default(0);
            $table->integer('active_members')->default(0);
            $table->integer('total_reservations')->default(0);
            $table->integer('total_events')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->decimal('total_expenses', 12, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_summary_reports');
        Schema::dropIfExists('event_reports');
        Schema::dropIfExists('room_usage_reports');
        Schema::dropIfExists('membership_reports');
        // Schema::dropIfExists('attendance_reports'); // DI-COMMENT
    }
};