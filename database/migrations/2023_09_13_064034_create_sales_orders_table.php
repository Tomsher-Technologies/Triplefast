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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->bigInteger('shipping_id')->unsigned();
            $table->foreign('shipping_id')->references('id')->on('shipping_addresses')->onDelete('cascade');
            $table->date('order_date');
            $table->integer("status")->default(1)->comment("1: Engineer, 2: Released, 3: Completed");
            $table->date('need_by_date');
            $table->date('ship_by_date');
            $table->string('po_number');
            $table->bigInteger('sales_person_id')->unsigned();
            $table->foreign('sales_person_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('terms');
            $table->string('shipping_terms');
            $table->string('shipping_via');
            $table->text('description');
            $table->timestamp('release_date')->nullable();
            $table->timestamp('completed_date')->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('sales_orders');
    }
};
