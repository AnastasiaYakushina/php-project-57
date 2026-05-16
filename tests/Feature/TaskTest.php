<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\Label;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskIndex(): void
    {
        $status = TaskStatus::factory()->create(['name' => 'в работе']);

        Task::factory()->create([
            'name' => 'Первая задача',
            'status_id' => $status->id,
            'created_at' => now(),
        ]);
        Task::factory()->create(['name' => 'Вторая задача']);

        $response = $this->get(route('tasks.index'));

        $response->assertOk();
        $response->assertSee('Первая задача');
        $response->assertSee('Вторая задача');
        $response->assertSee('в работе');
        $response->assertSee(now()->format('d.m.Y'));
        $response->assertDontSee('Задача не существует');
    }

    public function testTaskIndexAsGuest(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk();
        $response->assertDontSee('Создать');
        $response->assertDontSee('Изменить');
        $response->assertDontSee('Удалить');
    }

    public function testTaskRedirectToAuthPageForGuest(): void
    {
        $task = Task::factory()->create();

        $routes = [
            ['get', route('tasks.create'), []],
            ['get', route('tasks.edit', $task), []],
            ['post', route('tasks.store'), ['name' => 'test']],
            ['put', route('tasks.update', $task), ['name' => 'test']],
            ['delete', route('tasks.destroy', $task), []],
        ];

        foreach ($routes as [$method, $url, $data]) {
            $response = call_user_func([$this, $method], $url, $data);
            $response->assertForbidden();
        }
    }

    public function testTaskIndexAsAuthCreator(): void
    {
        $user = User::factory()->create();
        Task::factory()->create(['name' => 'Задача', 'created_by_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.index'));

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

        $response = $this->actingAs($user2)->get(route('tasks.index'));

        $response->assertOk();
        $response->assertSee('Создать');
        $response->assertSee('Изменить');
        $response->assertDontSee('Удалить');
    }

    public function testTaskShow(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create(['name' => 'Срочно']);
        $task = Task::factory()->create(['description' => 'Интересное описание интересной задачи']);
        $task->labels()->attach($label->id);

        $response = $this->actingAs($user)->get(route('tasks.show', $task));

        $response->assertOk();
        $response->assertSee('Описание');
        $response->assertSee('Интересное описание интересной задачи');
        $response->assertSee('Срочно');
    }

    public function testTaskCreate(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertOk();
        $response->assertSee('name="name"', false);
        $response->assertSee('name="description"', false);
        $response->assertSee('name="status_id"', false);
        $response->assertSee('name="assigned_to_id"', false);
    }

    public function testTaskStore(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $data = [
            'name' => 'Тестовая задача testTaskStore',
            'description' => 'Описание задачи',
            'status_id' => $status->id
        ];

        $response = $this->actingAs($user)->post(route('tasks.store'), $data);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'name' => 'Тестовая задача testTaskStore',
            'created_by_id' => $user->id
        ]);
    }

    public function testTaskEdit(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertOk();
        $response->assertSee('name="name"', false);
        $response->assertSee('name="description"', false);
        $response->assertSee('name="status_id"', false);
        $response->assertSee('name="assigned_to_id"', false);
    }

    public function testTaskUpdate(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['name' => 'Я до изменения']);
        $data = [
            'name' => 'Я изменен',
            'status_id' => $task->getAttribute('status_id'),
        ];

        $response = $this->actingAs($user)->patch(route('tasks.update', $task), $data);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Я изменен'
        ]);
    }

    public function testTaskDestroyByCreator(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    public function testTaskDestroyByNonCreator(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id]);

        $response = $this->actingAs($user2)->delete(route('tasks.destroy', $task));

        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function testTaskCorrectValidation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('tasks.create'))
            ->post(route('tasks.store'), [
                'name' => '',
                'status_id' => '',
            ]);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors(['name', 'status_id']);
        $this->assertEquals(
            'Это обязательное поле',
            session('errors')->first('name')
        );
    }

    public function testTaskFilters(): void
    {
        $createdBy = User::factory()->create();
        $assignedTo = User::factory()->create();
        $status = TaskStatus::factory()->create();

        Task::factory()->create([
            'name' => 'Нужная задача',
            'status_id' => $status->id,
            'created_by_id' => $createdBy->id,
            'assigned_to_id' => $assignedTo->id,
        ]);

        Task::factory()->create(['name' => 'Лишняя задача']);

        $response = $this->actingAs($createdBy)->get(route('tasks.index') . '?' . http_build_query([
            'filter' => [
                'status_id' => $status->id,
                'created_by_id' => $createdBy->id,
                'assigned_to_id' => $assignedTo->id,
            ]
        ]));

        $response->assertOk();
        $response->assertSee('Нужная задача');
        $response->assertDontSee('Лишняя задача');
    }
}
