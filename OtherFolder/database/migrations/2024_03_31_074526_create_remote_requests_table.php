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
        Schema::create('remote_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->foreign('emp_id')->references('id')->on('workfolio_main.employees')->onDelete('cascade');
            $table->string('request_reason')->nullable();
            $table->date('request_date')->nullable();
            $table->integer('total_score')->nullable();
            $table->enum('jobrole_suitability', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('performance_accountability', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('technological_readiness', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('communication_skills', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('work_environment', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('flexibility_adaptability', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('health_wellbeing', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('organizational_needs', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('legal_compliance', ['0', '1', '2', '3', '4', '5'])->default('0')->nullable();
            $table->enum('status', ['Approved', 'For Reveiwing' ,'Declined', 'Pending'])->default('Pending')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_requests');
    }
};
