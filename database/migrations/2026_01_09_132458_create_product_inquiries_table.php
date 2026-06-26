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
        Schema::create('product_inquiries', function (Blueprint $table) {
            $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Customer
        $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Order eka
        $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Product eka

        $table->text('message'); // Customer ge prashne
        $table->text('admin_reply')->nullable(); // Admin ge uththare

        // Status: pending, processing, resolved
        $table->string('status')->default('pending');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inquiries');
    }
};
