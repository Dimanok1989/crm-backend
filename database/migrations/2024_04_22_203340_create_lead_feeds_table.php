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
        Schema::create('lead_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->comment('Идентификатор заявки')->constrained();
            $table->foreignId('user_id')->nullable()->comment('Идентификатор пользователя')->constrained();
            $table->foreignId('status_id')->nullable()->comment('Идентификатор статуса при его смене');
            $table->foreignId('type')->nullable()->comment('Тип события');
            $table->text('content')->nullable()->comment('Текст события');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_feeds');
    }
};
