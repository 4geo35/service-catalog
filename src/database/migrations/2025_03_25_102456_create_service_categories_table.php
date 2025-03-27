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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string("title")
                ->comment("Заголовок");
            $table->string("slug")
                ->unique()
                ->comment("Адресная строка");
            $table->string("short")
                ->nullable();
            $table->text("description")
                ->nullable();
            $table->unsignedBigInteger("image_id")
                ->nullable()
                ->comment("Обложка");
            $table->unsignedBigInteger("priority")
                ->default(0)
                ->comment("Приоритет");
            $table->unsignedBigInteger("parent_id")
                ->nullable()
                ->comment("Родительская категория");
            $table->dateTime("published_at")
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
