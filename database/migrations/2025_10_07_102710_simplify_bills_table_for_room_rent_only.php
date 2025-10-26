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
        Schema::table('bills', function (Blueprint $table) {
            // Drop unnecessary columns for other fees
            $table->dropColumn([
                'electricity_amount',
                'water_amount', 
                'internet_amount',
                'maintenance_amount',
                'other_amount'
            ]);
            
            // Rename rent_amount to amount for simplicity
            $table->renameColumn('rent_amount', 'amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            // Add back the dropped columns
            $table->decimal('electricity_amount', 10, 2)->default(0)->after('amount');
            $table->decimal('water_amount', 10, 2)->default(0)->after('electricity_amount');
            $table->decimal('internet_amount', 10, 2)->default(0)->after('water_amount');
            $table->decimal('maintenance_amount', 10, 2)->default(0)->after('internet_amount');
            $table->decimal('other_amount', 10, 2)->default(0)->after('maintenance_amount');
            
            // Rename back to rent_amount
            $table->renameColumn('amount', 'rent_amount');
        });
    }
};