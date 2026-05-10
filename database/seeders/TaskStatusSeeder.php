<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
        'новый',
        'в работе',
        'на тестировании',
        'завершен'
        ];

        foreach ($statuses as $statusName) {
            TaskStatus::updateOrCreate([
                'name' => $statusName
            ]);
        }
    }
}
