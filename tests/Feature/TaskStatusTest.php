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

        $response = $this->get(route('task_statuses.index'));

        $response->assertOk();
        $response->assertSee('В работе');
        $response->assertSee('Новый');
        $response->assertDontSee('Не существует');
    }

    public function testTaskStatusesIndexAsGuest(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertOk();
        $response->assertDontSee('Создать');
        $response->assertDontSee('Изменить');
        $response->assertDontSee('Удалить');
    }

    public function testTaskStatusesRedirectToAuthPageForGuest(): void
    {
        $status = TaskStatus::factory()->create();

        $routes = [
            ['get', route('task_statuses.create'), []],
            ['get', route('task_statuses.edit', $status), []],
            ['post', route('task_statuses.store'), ['name' => 'test']],
            ['put', route('task_statuses.update', $status), ['name' => 'test']],
            ['delete', route('task_statuses.destroy', $status), []],
        ];

        foreach ($routes as [$method, $url, $data]) {
            $response = call_user_func([$this, $method], $url, $data);
            $response->assertForbidden();
        }
    }

    public function testTaskStatusesCreate(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('task_statuses.create'));

        $response->assertOk();
        $response->assertSee('name="name"', false);
    }

    public function testTaskStatusesStore(): void
    {
        $user = User::factory()->create();
        $data = ['name' => 'Я создан'];

        $response = $this->actingAs($user)->post(route('task_statuses.store'), $data);

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', ['name' => 'Я создан']);
    }

    public function testTaskStatusesEdit(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($user)->get(route('task_statuses.edit', $status));

        $response->assertOk();
        $response->assertSee('name="name"', false);
    }

    public function testTaskStatusesUpdate(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create(['name' => 'Я до изменения']);
        $data = ['name' => 'Я изменен'];

        $response = $this->actingAs($user)->patch(route('task_statuses.update', $status), $data);

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', ['name' => 'Я изменен']);
    }

    public function testTaskStatusesDestroy(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    public function testTaskStatusesWithTaskNonDestroy(): void
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        Task::factory()->create(['status_id' => $status->id]);

        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function testTaskStatusesCorrectValidation(): void
    {
        $user = User::factory()->create();

        $data = ['name' => ''];

        $response = $this->actingAs($user)
            ->from(route('task_statuses.create'))
            ->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.create'));
        $response->assertSessionHasErrors(['name' => 'Это обязательное поле']);

        $data = ['name' => 'Название статуса'];

        $response = $this->actingAs($user)->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.index'));

        $data = ['name' => 'Название статуса'];

        $response = $this->actingAs($user)
            ->from(route('task_statuses.create'))
            ->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.create'));
        $response->assertSessionHasErrors(['name' => 'Статус с таким именем уже существует']);
    }
}
