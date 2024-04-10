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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->string('task_name')->nullable();
            $table->string('description')->nullable();
            $table->string('due_date')->nullable();
            $table->string('task_progress')->nullable();
            $table->enum('task_status', ['Open', 'OnProgress', 'Overdue', 'Completed'])->nullable();
            $table->foreign('emp_id')->references('id')->on('workfolio_main.employees')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('restrict')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
