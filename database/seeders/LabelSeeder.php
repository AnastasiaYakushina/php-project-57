<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Label;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labels = [
            ['name' => 'Bug', 'description' => 'Критические ошибки, ломающие функционал'],
            ['name' => 'Feature', 'description' => 'Разработка новой функциональности'],
            ['name' => 'Refactoring', 'description' => 'Оптимизация и улучшение структуры кода'],
            ['name' => 'Documentation', 'description' => 'Обновление документации или инструкций'],
            ['name' => 'Frontend', 'description' => 'Задачи по верстке, стилям и интерфейсу'],
            ['name' => 'Backend', 'description' => 'Работа с серверной логикой, базами данных и API'],
            ['name' => 'Testing', 'description' => 'Покрытие тестами или ручное тестирование'],
            ['name' => 'Design', 'description' => 'Разработка макетов, иконок или UI/UX элементов'],
            ['name' => 'Security', 'description' => 'Уязвимости, доступы и безопасность данных'],
            ['name' => 'DevOps', 'description' => 'Настройка серверов, CI/CD и деплоя'],
            ['name' => 'Urgent', 'description' => 'Срочные задачи, требующие немедленного выполнения'],
        ];

        foreach ($labels as $label) {
            Label::updateOrCreate(
                ['name' => $label['name']],
                ['description' => $label['description']]
            );
        }
    }
}
