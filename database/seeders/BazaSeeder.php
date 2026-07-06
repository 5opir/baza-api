<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Credit;
use App\Models\Commercial;
use App\Models\Article;
use App\Models\AboutUs;

class BazaSeeder extends Seeder
{
    public function run(): void
    {
        // ============ КИНО / СЕРИАЛЫ ============
        $films = [
            [
                'type' => 'fiction',
                'title' => 'Тень города',
                'genre' => 'Триллер',
                'format' => 'Полнометражный фильм',
                'cover' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=600',
                'poster' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=400',
                'description' => 'Детектив расследует серию загадочных исчезновений в промышленном городе.',
                'full_description' => 'В центре сюжета — опытный детектив Алексей Морок...',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'credits' => [
                    ['role' => 'Режиссёр', 'name' => 'Андрей Волков'],
                    ['role' => 'Сценарий', 'name' => 'Марина Лебедева'],
                    ['role' => 'В ролях', 'name' => 'Игорь Петров, Анна Козлова'],
                ],
            ],
            [
                'type' => 'fiction',
                'title' => 'Последний рассвет',
                'genre' => 'Драма',
                'format' => 'Сериал (8 серий)',
                'cover' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=600',
                'poster' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=400',
                'description' => 'История трёх поколений семьи, живущих на берегу моря.',
                'full_description' => 'Масштабная семейная сага...',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'credits' => [
                    ['role' => 'Режиссёр', 'name' => 'Елена Морская'],
                    ['role' => 'Сценарий', 'name' => 'Павел Береговой'],
                ],
            ],
            [
                'type' => 'documentary',
                'title' => 'Голоса тайги',
                'genre' => 'Документальный',
                'format' => 'Полнометражный',
                'cover' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600',
                'poster' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400',
                'description' => 'Путешествие вглубь сибирской тайги.',
                'full_description' => 'Документальный фильм, снятый в течение двух лет экспедиций...',
                'trailer_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'credits' => [
                    ['role' => 'Режиссёр / Оператор', 'name' => 'Сергей Глухой'],
                ],
            ],
        ];

        foreach ($films as $filmData) {
            $credits = $filmData['credits'];
            unset($filmData['credits']);

            $film = Film::create($filmData);

            foreach ($credits as $i => $credit) {
                Credit::create([
                    'film_id'    => $film->id,
                    'role'       => $credit['role'],
                    'name'       => $credit['name'],
                    'sort_order' => $i,
                ]);
            }
        }

        // ============ РЕКЛАМА / КЛИПЫ ============
        $commercials = [
            ['category' => 'advertising', 'title' => 'Новая линейка электрокаров', 'company' => 'AutoVolt', 'description' => 'Рекламный ролик для запуска нового электрокара.', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
            ['category' => 'advertising', 'title' => 'Вкус, который объединяет', 'company' => 'FoodBrand', 'description' => 'Тёплый семейный ролик для бренда продуктов.', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
            ['category' => 'image', 'title' => 'Будущее строим мы', 'company' => 'СтройГрупп', 'description' => 'Имиджевый фильм о миссии компании.', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
            ['category' => 'clips', 'title' => '«Северный ветер» — official music video', 'company' => 'Артист: Лунный Пёс', 'description' => 'Музыкальный клип с сюжетной линией.', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
            ['category' => 'reels', 'title' => 'Behind the scenes: Fashion Week', 'company' => 'BrandX', 'description' => 'Серия Reels с закулисной съёмкой.', 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
        ];

        foreach ($commercials as $c) {
            Commercial::create($c);
        }

        // ============ СТАТЬИ ============
        $articles = [
            ['title' => 'Киностудия ОЛЬМО — лучший продакшн года', 'cover' => 'https://media.dynamo.su/iblock/cf4/mdxcps6bkpo1zexfslwln0vxf0zoh6fc.jpeg', 'url' => 'https://ru.wikipedia.org/'],
            ['title' => 'Как мы снимали «Тень города»', 'cover' => 'https://media.dynamo.su/iblock/cf4/mdxcps6bkpo1zexfslwln0vxf0zoh6fc.jpeg', 'url' => 'https://ru.wikipedia.org/'],
            ['title' => 'Интервью с режиссёром Андреем Волковым', 'cover' => 'https://media.dynamo.su/iblock/cf4/mdxcps6bkpo1zexfslwln0vxf0zoh6fc.jpeg', 'url' => 'https://ru.wikipedia.org/'],
        ];

        foreach ($articles as $a) {
            Article::create($a);
        }

        // ============ О НАС ============
        AboutUs::create([
            'cover' => 'https://sun9-40.userapi.com/s/v1/ig2/r9lEk3DYVtngXNUL2k3X5UOZs8Lvy9pwtNME_0-AsSvsaP549XyS4zg.jpg',
            'info'  => 'Киностудия ОЛЬМО — креативный продакшн из Уфы. Мы снимаем кино, сериалы, рекламу и музыкальные клипы с 2015 года. Наша команда — это более 30 профессионалов, влюблённых в своё дело.',
        ]);
    }
}