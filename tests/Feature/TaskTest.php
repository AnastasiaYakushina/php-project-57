<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskIndex(): void
    {
        Task::factory()->create(['name' => 'Первая задача']);
        Task::factory()->create(['name' => 'Вторая задача']);
        $response = $this->get('/tasks');
        $response->assertOk();
        $response->assertSee('Первая задача');
        $response->assertSee('Вторая задача');
        $response->assertDontSee('Задача не существует');
    }

    public function testTaskIndexAsGuest(): void
    {
        $response = $this->get('/tasks');
        $response->assertOk();
        $response->assertDontSee('Создать');
        $response->assertDontSee('Изменить');
        $response->assertDontSee('Удалить');
    }

    public function testTaskRedirectToAuthPageForGuest(): void
    {
        $routes = [
            ['get', 'tasks/create', []],
            ['get', 'tasks/1/edit', []],
            ['post', 'tasks', ['name' => 'test']],
            ['put', 'tasks/1', ['name' => 'test']],
            ['delete', 'tasks/1', []],
        ];

        foreach ($routes as [$method, $url, $data]) {
            $response = $this->$method($url, $data);
            $response->assertRedirect('/login');
        }
    }

    public function testTaskIndexAsAuthCreator(): void
    {
        $user1 = User::factory()->create();
        Task::factory()->create(['name' => 'Задача', 'created_by_id' => $user1->id]);
        $response = $this->actingAs($user1)->get('/tasks');
        $response->assertOk();
        $response->assertSee('Создать');
        $response->assertSee('Изменить');
        $response->assertSee('Удалить');
    }

    public function testTaskIndexAsAuthNonCreator(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Task::factory()->create(['name' => 'Задача', 'created_by_id' => $user1->id]);
        $response = $this->actingAs($user2)->get('/tasks');
        $response->assertOk();
        $response->assertSee('Создать');
        $response->assertSee('Изменить');
        $response->assertDontSee('Удалить');
    }
}
