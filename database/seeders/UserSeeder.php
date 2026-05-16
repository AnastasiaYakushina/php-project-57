<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Дарья Каренина', 'email' => 'anastasia@example.com'],
            ['name' => 'Александр Ростов', 'email' => 'alex@example.com'],
            ['name' => 'Дмитрий Раскольников', 'email' => 'dmitry@example.com'],
            ['name' => 'Елена Печорина', 'email' => 'elena@example.com'],
            ['name' => 'Иван Онегин', 'email' => 'ivan@example.com'],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}
