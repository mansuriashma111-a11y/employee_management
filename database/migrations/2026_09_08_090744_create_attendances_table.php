<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->foreignId('employee_id')
              ->constrained('employees')
              ->onDelete('cascade');

        $table->date('attendance_date');

        $table->time('check_in')->nullable();
        $table->time('check_out')->nullable();

        $table->enum('status', [
            'Present',
            'Absent',
            'Half Day',
            'Leave'
        ])->default('Present');

        $table->text('remarks')->nullable();

        $table->timestamps();

        // Same employee ki same date par duplicate attendance nahi
        $table->unique(['employee_id', 'attendance_date']);
    });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
