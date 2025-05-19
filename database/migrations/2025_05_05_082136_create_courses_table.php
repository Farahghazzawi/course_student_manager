<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->integer('credit_hours');
            $table->time('start_time')->nullable();  // Format: 14:30:00
            $table->time('end_time')->nullable(); // Format: 14:30:00
            $table->string('days_of_week', 20)->nullable(); // e.g., "MWF" or "Tue,Thu"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
