<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (! Schema::hasColumn('contacts', 'form_type')) {
                $table->string('form_type', 50)->default('contact')->after('id');
            }
            if (! Schema::hasColumn('contacts', 'phone')) {
                $table->string('phone', 50)->nullable()->after('email');
            }
            if (! Schema::hasColumn('contacts', 'guests')) {
                $table->string('guests', 50)->nullable()->after('message');
            }
            if (! Schema::hasColumn('contacts', 'checkin')) {
                $table->date('checkin')->nullable()->after('guests');
            }
            if (! Schema::hasColumn('contacts', 'checkout')) {
                $table->date('checkout')->nullable()->after('checkin');
            }
            if (! Schema::hasColumn('contacts', 'nights')) {
                $table->string('nights', 50)->nullable()->after('checkout');
            }
            if (! Schema::hasColumn('contacts', 'status')) {
                $table->string('status', 20)->default('new')->after('nights');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $columns = ['form_type', 'phone', 'guests', 'checkin', 'checkout', 'nights', 'status'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('contacts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
