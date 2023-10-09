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
        Schema::create('job_card_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_card_id')->unsigned();
            $table->foreign('job_card_id')->references('id')->on('job_cards')->onDelete('cascade');
            $table->string('seq_no')->nullable();
            $table->bigInteger('job_part_id')->unsigned();
            $table->foreign('job_part_id')->references('id')->on('parts')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('req_qty')->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_materials');
    }
};
