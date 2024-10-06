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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id'); // Foreign key to Companies table
            $table->unsignedBigInteger('invoice_id')->nullable(); // Foreign key to Invoices table (optional)
            $table->string('file_name');
            $table->string('file_path'); // Stores the file path in the storage
            $table->string('file_type'); // E.g., PDF, JPG, PNG
            $table->decimal('file_size', 10, 2); // Size of the file in KB or MB
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
