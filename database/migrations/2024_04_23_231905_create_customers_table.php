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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->comment('Идентификатор пользователя')->constrained();
            $table->string('phone')->nullable()->comment('Основной номер телефона')->index();
            $table->string('email')->nullable()->comment('Основной email');
            $table->string('lastname')->nullable()->comment('Фамилия');
            $table->string('firstname')->nullable()->comment('Имя');
            $table->string('patronymic')->nullable()->comment('Отчество');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
