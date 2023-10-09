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
        Schema::create('job_card_operations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_card_id')->unsigned();
            $table->foreign('job_card_id')->references('id')->on('job_cards')->onDelete('cascade');
            $table->string('seq_no')->nullable();
            $table->bigInteger('job_operation_id')->unsigned();
            $table->foreign('job_operation_id')->references('id')->on('operations')->onDelete('cascade');
            $table->text('op_comment')->nullable();
            $table->string('op_qty')->default(0);
            $table->boolean('status')->default(0)->comment("1: Completed, 0: Not completed");
            $table->boolean('is_deleted')->default(0);
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->date('deleted_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_operations');
    }
};
