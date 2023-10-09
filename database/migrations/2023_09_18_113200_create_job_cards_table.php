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
        Schema::create('job_cards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('sales_orders')->onDelete('cascade');
            $table->bigInteger('order_part_id')->unsigned();
            $table->foreign('order_part_id')->references('id')->on('sales_order_parts')->onDelete('cascade');
            $table->string('job_number')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('order_processer')->unsigned();
            $table->foreign('order_processer')->references('id')->on('users')->onDelete('cascade');
            $table->date('due_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('need_by_date')->nullable();
            $table->date('req_date')->nullable();
            $table->string('qty_req')->default(0);
            $table->string('for_order')->default(0);
            $table->string('for_stock')->default(0);
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
        Schema::dropIfExists('job_cards');
    }
};
