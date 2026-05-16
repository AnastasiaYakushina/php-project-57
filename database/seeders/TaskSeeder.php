<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Task;
use App\Models\Label;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultUser = User::first()?->id ?? 1;
        $defaultStatus = TaskStatus::first()?->id ?? 1;
        $labels = Label::all();

        $tasks = [
            ['name' => 'Исправить баг с авторизацией через GitHub'],
            ['name' => 'Добавить валидацию форм на странице профиля'],
            ['name' => 'Оптимизировать SQL-запросы в личном кабинете'],
            ['name' => 'Написать документацию для REST API методов'],
            ['name' => 'Сверстать адаптивное меню для мобильных устройств'],
            ['name' => 'Реализовать выгрузку отчетов в формат Excel'],
            ['name' => 'Настроить CI/CD пайплайн для автоматического деплоя'],
            ['name' => 'Покрыть тестами контроллер управления задачами'],
            ['name' => 'Обновить дизайн главной страницы под новый брендбук'],
            ['name' => 'Исправить утечку памяти при обработке изображений'],
            ['name' => 'Интегрировать платежный шлюз Stripe'],
            ['name' => 'Настроить отправку уведомлений на Email'],
        ];

        foreach ($tasks as $taskData) {
            $task = Task::create([
                'name' => $taskData['name'],
                'description' => 'Подробное описание для задачи: ' . $taskData['name'],
                'status_id' => TaskStatus::inRandomOrder()->first()?->id ?? $defaultStatus,
                'created_by_id' => User::inRandomOrder()->first()?->id ?? $defaultUser,
                'assigned_to_id' => User::inRandomOrder()->first()?->id ?? $defaultUser,
            ]);

            if ($labels->isNotEmpty()) {
                $randomLabels = $labels->random(rand(1, 3))->pluck('id');
                $task->labels()->attach($randomLabels);
            }
        }
    }
}
