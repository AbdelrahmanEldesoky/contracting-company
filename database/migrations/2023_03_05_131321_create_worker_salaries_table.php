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
        Schema::create('worker_salaries', function (Blueprint $table) {
            $table->id();
            $table->Integer('worker_id')->unsigned();
            $table->Integer('project_id');
            $table->integer('hours')->default(0);
            $table->integer('sallary')->default(0);
            $table->integer('add_sallary')->default(0);
            $table->integer('deduct_sallary')->default(0);
            $table->integer('total_sallary')->default(0);
            $table->date('date_at');
            $table->integer('Presence')->default(0);
            $table->timestamps();
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_salaries');
    }
};
