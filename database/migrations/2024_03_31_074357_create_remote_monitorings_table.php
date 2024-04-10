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
        Schema::create('remote_monitorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->foreign('emp_id')->references('id')->on('workfolio_main.employees')->onDelete('cascade');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->enum('status', ['Cancelled' ,'On Progress', 'Completed'])->nullable();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('meeting_id')->references('id')->on('remote_meetings')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('schedule_id')->references('id')->on('remote_schedules')->onDelete('restrict')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_monitorings');
    }
};
