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
        Schema::table('users', function (Blueprint $table) {

        $table->enum('role', ['customer', 'designer','admin'])->default('customer')->after('email');

        // Personal Details
        $table->string('phone')->nullable()->after('password');
        $table->text('address')->nullable()->after('phone');

       
        $table->string('company_name')->nullable()->after('address');
        $table->string('company_email')->nullable()->after('company_name');
        $table->string('company_phone')->nullable()->after('company_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'address', 'company_name', 'company_email', 'company_phone']);
        });
    }
};
