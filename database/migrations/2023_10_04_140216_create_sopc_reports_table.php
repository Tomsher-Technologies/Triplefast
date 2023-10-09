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
        Schema::create('sopc_reports', function (Blueprint $table) {
            $table->id();
            $table->string('so_number');
            $table->date('enter_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('started_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('target_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->integer('total_items')->nullable();
            $table->string('division')->nullable();
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('po_number')->nullable();
            $table->text('jobs_to_do')->nullable();
            $table->integer('job_status')->nullable()->comment('0-Not Started, 1-Started, 2-Partial, 3-Hold, 4-Completed, 5-Cancelled');
            $table->date('machining')->nullable();
            $table->date('heat_treatment')->nullable();
            $table->date('s1_date')->nullable();
            $table->date('subcon')->nullable();
            $table->date('stock')->nullable();
            $table->string('total_value')->nullable();
            $table->boolean('is_active')->default('1');
            $table->boolean('is_deleted')->default('0');
            $table->bigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sopc_reports');
    }
};
