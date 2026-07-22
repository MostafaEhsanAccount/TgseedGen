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
            $table->dropForeign(['tenant_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->change();
            $table->boolean('is_super_admin')->default(false)->after('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('is_super_admin');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable(false)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
        });
    }
};
