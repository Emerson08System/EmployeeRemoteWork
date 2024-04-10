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
        Schema::create('remote_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('organizer_id')->nullable();
            $table->dateTime('meeting_date')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->string('location')->nullable();
            $table->string('description')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('attendies')->nullable();
            $table->enum('status', ['Approved' ,'Declined', 'Pending'])->default('Pending')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_meetings');
    }
};
