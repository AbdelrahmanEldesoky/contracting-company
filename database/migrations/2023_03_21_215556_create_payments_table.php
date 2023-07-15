<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id')->unsigned();
            $table->unsignedBigInteger('project_id');
            $table->integer('value');
            $table->integer('user_id');
            $table->string('statement');
            $table->timestamps();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
