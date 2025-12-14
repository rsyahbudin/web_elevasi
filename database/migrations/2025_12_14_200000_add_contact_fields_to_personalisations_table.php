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
        Schema::table('personalisations', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('copyright_text');
            $table->string('email')->nullable()->after('phone');
            $table->string('whatsapp')->nullable()->after('email');
            $table->string('address')->nullable()->after('whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personalisations', function (Blueprint $table) {
            $table->dropColumn(['phone', 'email', 'whatsapp', 'address']);
        });
    }
};
