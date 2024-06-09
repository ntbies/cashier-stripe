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
            $table->string('stripe_account_id')->nullable()->index();
            $table->boolean('stripe_details_submitted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn([
                'stripe_account_id',
                'stripe_details_submitted',
            ]);
        });
    }
};
