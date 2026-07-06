<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============ КИНО / СЕРИАЛЫ ============
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['fiction', 'documentary'])->index();
            $table->string('title');
            $table->string('genre');
            $table->string('format');                 // "Полнометражный", "Сериал (8 серий)"
            $table->string('cover');                  // URL обложки для карточки
            $table->string('poster')->nullable();     // URL постера для детальной страницы
            $table->text('description');              // краткое описание
            $table->text('full_description')->nullable();
            $table->string('trailer_url')->nullable();
            $table->timestamps();
        });

        // ============ ТИТРЫ (связь с фильмом) ============
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained()->onDelete('cascade');
            $table->string('role');   // "Режиссёр", "Сценарий", "В ролях"
            $table->string('name');   // "Андрей Волков"
            $table->integer('sort_order')->default(0); // для порядка вывода
            $table->timestamps();
        });

        // ============ РЕКЛАМА / КЛИПЫ / REELS ============
        Schema::create('commercials', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['advertising', 'image', 'clips', 'reels'])->index();
            $table->string('title');
            $table->string('company');                // компания-заказчик
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });

        // ============ СТАТЬИ "ЧТО ПИШУТ О НАС" ============
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('cover')->nullable();
            $table->string('url');                    // внешняя ссылка
            $table->timestamps();
        });

        // ============ СТРАНИЦА "О НАС" ============
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('cover')->nullable();
            $table->text('info');
            $table->timestamps();
        });

        // ============ ЗАЯВКИ НА СЪЁМКУ ============
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');                // телефон или email
            $table->string('project_type')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['new', 'in_progress', 'done'])
                  ->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('about_us');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('credits');
        Schema::dropIfExists('commercials');
        Schema::dropIfExists('films');
    }
};