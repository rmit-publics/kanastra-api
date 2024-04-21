<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('file_upload_id');
            $table->string('government_id');
            $table->string('name');
            $table->string('email');
            $table->string('debt_id');
            $table->integer('debt_amount');
            $table->date('debt_due_date');
            $table->enum('status', ['W', 'F', 'E']);
            $table->integer('attempts')->default(0);
            $table->text('error_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
