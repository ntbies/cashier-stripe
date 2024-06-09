<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('stripe_id')->nullable()->index();
            $table->string('line1')->nullable();
            $table->string('line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code', 25)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('vat_id', 50)->nullable();
            $table->string('vat_id_type', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn([
                'stripe_id',
                'line1',
                'line2',
                'city',
                'state',
                'postal_code',
                'country',
                'vat_id',
                'vat_id_type',
            ]);
        });
    }
};
