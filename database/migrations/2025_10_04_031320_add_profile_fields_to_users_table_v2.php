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
            $table->date('birth_date')->nullable()->after('address');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
            $table->string('occupation')->nullable()->after('gender');
            $table->string('emergency_contact_name')->nullable()->after('occupation');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->string('id_card_number')->nullable()->after('emergency_contact_phone');
            $table->string('id_card_file')->nullable()->after('id_card_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date',
                'gender', 
                'occupation',
                'emergency_contact_name',
                'emergency_contact_phone',
                'id_card_number',
                'id_card_file'
            ]);
        });
    }
};
