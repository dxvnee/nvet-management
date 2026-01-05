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
            $table->boolean('is_inactive')->default(false)->after('hari_libur');
            $table->boolean('inactive_permanent')->default(true)->after('is_inactive');
            $table->date('inactive_start_date')->nullable()->after('inactive_permanent');
            $table->date('inactive_end_date')->nullable()->after('inactive_start_date');
            $table->text('inactive_reason')->nullable()->after('inactive_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_inactive',
                'inactive_permanent',
                'inactive_start_date',
                'inactive_end_date',
                'inactive_reason'
            ]);
        });
    }
};
