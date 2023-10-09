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
        Schema::create('sopc_timeline', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sopc_id')->unsigned();
            $table->foreign('sopc_id')->references('id')->on('sopc_reports')->onDelete('cascade');
            $table->text('content');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_active')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sopc_timeline');
    }
};
