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
        $tables = [
            'billings',
            'billing_items',
            'categories',
            'customers',
            'emis',
            'payables',
            'products',
            'purchases',
            'purchase_items',
            'suppliers',
            'vendors',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {

                // agar pehle se user_id hai to skip
                if (!Schema::hasColumn($tableName, 'user_id')) {

                    $table->foreignId('user_id')
                          ->nullable() // existing data ke liye
                          ->after('id')
                          ->constrained()
                          ->cascadeOnDelete();
                }
            });
        }



        // Schema::table('multiple_tables', function (Blueprint $table) {
        //     //
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          $tables = [
                'billings',
                'billing_items',
                'categories',
                'customers',
                'emis',
                'payables',
                'products',
                'purchases',
                'purchase_items',
                'suppliers',
                'vendors',
            ];

            foreach ($tables as $tableName) {
                Schema::table($tableName, function (Blueprint $table) {

                    if (Schema::hasColumn($table->getTable(), 'user_id')) {
                        $table->dropForeign(['user_id']);
                        $table->dropColumn('user_id');
                    }
                });
            }



        // Schema::table('multiple_tables', function (Blueprint $table) {
        //     //
        // });
    }
};
