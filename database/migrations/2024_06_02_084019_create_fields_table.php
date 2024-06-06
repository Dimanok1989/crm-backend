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
        Schema::create('fields', function (Blueprint $table) {
            $table->comment('Пользовательские поля');
            $table->id();
            $table->foreignId('user_id')->comment('Идентификатор пользователя')->constrained();
            $table->string('fieldable')->comment('Сущность добавления поля');
            $table->string('type')->comment('Тип поля');
            $table->string('title')->comment('Наименование поля');
            $table->string('placeholder')->nullable();
            $table->text('attributes')->nullable()->comment('Дополнительные данные');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
