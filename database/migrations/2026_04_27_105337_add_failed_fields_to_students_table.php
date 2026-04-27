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
    Schema::table('students', function (Blueprint $table) {
        $table->string('notification_status')->default('pending');
        $table->text('notification_error')->nullable();
        $table->timestamp('notification_sent_at')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropColumn([
            'notification_status',
            'notification_error',
            'notification_sent_at'
        ]);
    });
}
};
