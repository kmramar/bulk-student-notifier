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
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();

            // Template Name (Admin ke liye identify karne ke liye)
            $table->string('title');

            // Type: email ya sms
            $table->enum('type', ['email', 'sms']);

            // Email subject (sirf email ke liye)
            $table->string('subject')->nullable();

            // Message content
            $table->text('message');

            // Optional variables (JSON format - jaise {name}, {email})
            $table->json('variables')->nullable();

            // Active ya inactive
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};