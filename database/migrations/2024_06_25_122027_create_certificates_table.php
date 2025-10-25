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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->string('test_date')->nullable();
            $table->decimal('mark_obtained')->nullable();
            $table->string('image')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('grade')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('contact_hour')->nullable();
            $table->enum('type', ['regular', 'test'])->default('regular')->nullable();
            $table->boolean('is_old')->default(false);
            $table->boolean('is_download')->default(false);
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
        Schema::dropIfExists('certificates');
    }
};
