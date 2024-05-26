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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('Идентификатор пользователя')->constrained();
            $table->foreignId('status_id')->comment('Идентификатор статуса заявки');
            $table->timestamp('event_start_at')->nullable()->comment('Дата начала события');
            $table->string('name')->nullable()->comment('Наименование заявки');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
