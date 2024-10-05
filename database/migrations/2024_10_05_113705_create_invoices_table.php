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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable(); // Foreign key to the Companies table
            $table->string('invoice_number')->unique();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_tax_id')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->enum('type', ['incoming', 'outgoing'])->nullable();
            $table->timestamps();

            // Foreign key constraint
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
