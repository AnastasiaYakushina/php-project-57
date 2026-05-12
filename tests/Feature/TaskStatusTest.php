<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskStatusesIndex(): void
    {
        TaskStatus::factory()->create(['name' => 'В работе']);
        TaskStatus::factory()->create(['name' => 'Новый']);
        $response = $this->get('/task_statuses');
        $response->assertOk();
        $response->assertSee('В работе');
        $response->assertSee('Новый');
        $response->assertDontSee('Не существует');
    }

    public function testTaskStatusesIndexAsGuest(): void
    {
        $response = $this->get('/task_statuses');
        $response->assertOk();
        $response->assertDontSee('Создать');
        $response->assertDontSee('Изменить');
        $response->assertDontSee('Удалить');
    }

    public function testTaskStatusesRedirectToAuthPageForGuest(): void
    {
        $routes = [
            ['get', 'task_statuses/create', []],
            ['get', 'task_statuses/1/edit', []],
            ['post', 'task_statuses', ['name' => 'test']],
            ['put', 'task_statuses/1', ['name' => 'test']],
            ['delete', 'task_statuses/1', []],
        ];

        foreach ($routes as [$method, $url, $data]) {
            $response = $this->$method($url, $data);
            $response->assertRedirect('/login');
        }
    }

    public function testTaskStatusesCreate(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('task_statuses/create');
        $response->assertOk();
        $response->assertSee('name="name"', false);
    }

    public function testTaskStatusesStore(): void
    {
        $user = User::factory()->create();
        $data = ['name' => 'Я создан'];
        $response = $this->actingAs($user)->post('task_statuses', $data);
        $response->assertRedirect('/task_statuses');
        $status = TaskStatus::where('name', 'Я создан')->first();
        $this->assertNotNull($status);
    }

    public function testTaskStatusesEdit(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $response = $this->actingAs($user)->get('task_statuses/1/edit');
        $response->assertOk();
        $response->assertSee('name="name"', false);
    }

    public function testTaskStatusesUpdate(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create(['name' => 'Я до изменения']);
        $data = ['name' => 'Я изменен'];
        $response = $this->actingAs($user)->patch("task_statuses/{$status->id}", $data);
        $response->assertRedirect('/task_statuses');
        $updatedStatus = TaskStatus::where('name', 'Я изменен')->first();
        $this->assertNotNull($updatedStatus);
    }

    public function testTaskStatusesDestroy(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $response = $this->actingAs($user)->delete("task_statuses/{$status->id}");
        $response->assertRedirect('/task_statuses');
        $this->assertNull(TaskStatus::all()->first());
    }

    public function testTaskStatusesWithTaskNonDestroy(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create(['status_id' => $status->id]);
        $response = $this->actingAs($user)->delete("task_statuses/{$status->id}");
        $response->assertRedirect('/task_statuses');
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function testTaskStatusesCorrectValidation(): void
    {
        $user = User::factory()->create();
        $data = ['name' => ''];
        $response = $this->actingAs($user)
            ->from('/task_statuses/create')
            ->post('task_statuses', $data);
        $response->assertRedirect('/task_statuses/create');
        $response->assertSessionHasErrors(['name' => 'Это обязательное поле']);

        $data = ['name' => 'Название статуса'];
        $response = $this->actingAs($user)->post('task_statuses', $data);
        $response->assertRedirect('/task_statuses');

        $data = ['name' => 'Название статуса'];
        $response = $this->actingAs($user)
            ->from('/task_statuses/create')
            ->post('task_statuses', $data);
        $response->assertRedirect('/task_statuses/create');
        $response->assertSessionHasErrors(['name' => 'Статус с таким именем уже существует']);
    }
}
