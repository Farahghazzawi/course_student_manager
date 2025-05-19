<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('emergency_phone_number');
            $table->text('address')->nullable();
            $table->text('blood_type')->nullable();
            
            // Add this for nationality dropdown
            $table->enum('nationality', ['Lebanese', 'Syrian', 'Palestinian', 'Jordanian', 'Iraqi', 'Egyptian', 'Other'])->default('Lebanese');
            
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
        Schema::dropIfExists('students');
    }
}
