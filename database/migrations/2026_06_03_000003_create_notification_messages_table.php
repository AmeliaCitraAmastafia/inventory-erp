<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_messages', function (Blueprint $table): void {
            $table->id();
            $table->enum('channel', ['email', 'whatsapp', 'internal']);
            $table->string('recipient', 150);
            $table->string('subject', 150);
            $table->text('message');
            $table->string('status', 30)->default('queued');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_messages');
    }
};
