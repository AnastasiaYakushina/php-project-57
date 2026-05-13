<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\Label;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public function testLabelsStatusesIndex(): void
    {
        Label::factory()->create(['name' => 'Срочно']);
        Label::factory()->create(['name' => 'Важно']);
        $response = $this->get('/labels');
        $response->assertOk();
        $response->assertSee('Срочно');
        $response->assertSee('Важно');
        $response->assertDontSee('Не существует');
    }

    public function testLabelsIndexAsGuest(): void
    {
        $response = $this->get('/labels');
        $response->assertOk();
        $response->assertDontSee('Создать');
        $response->assertDontSee('Изменить');
        $response->assertDontSee('Удалить');
    }

    public function testLabelsRedirectToAuthPageForGuest(): void
    {
        $routes = [
            ['get', 'labels/create', []],
            ['get', 'labels/1/edit', []],
            ['post', 'labels', ['name' => 'test']],
            ['put', 'labels/1', ['name' => 'test']],
            ['delete', 'labels/1', []],
        ];

        foreach ($routes as [$method, $url, $data]) {
            $response = $this->$method($url, $data);
            $response->assertRedirect('/login');
        }
    }

    public function testLabelsCreate(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('labels/create');
        $response->assertOk();
        $response->assertSee('name="name"', false);
        $response->assertSee('name="description"', false);
    }

    public function testLabelsStore(): void
    {
        $user = User::factory()->create();
        $data = ['name' => 'Я создана'];
        $response = $this->actingAs($user)->post('labels', $data);
        $response->assertRedirect('/labels');
        $label = Label::where('name', 'Я создана')->first();
        $this->assertNotNull($label);
    }

    public function testLabelsEdit(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $response = $this->actingAs($user)->get('labels/1/edit');
        $response->assertOk();
        $response->assertSee('name="name"', false);
    }

    public function testLabelsUpdate(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create(['name' => 'Я до изменения']);
        $data = ['name' => 'Я изменена', 'description' => 'Новое описание'];
        $response = $this->actingAs($user)->patch("labels/{$label->id}", $data);
        $response->assertRedirect('/labels');
        $updatedLabel = Label::where('name', 'Я изменена')->where('description', 'Новое описание')->first();
        $this->assertNotNull($updatedLabel);
    }

    public function testLabelDestroy(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $response = $this->actingAs($user)->delete("labels/{$label->id}");
        $response->assertRedirect('/labels');
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testLabelsWithTaskNonDestroy(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach($label->id);
        $response = $this->actingAs($user)->delete("labels/{$label->id}");
        $response->assertRedirect('/labels');
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function testLabelsCorrectValidation(): void
    {
        $user = User::factory()->create();
        $data = ['name' => ''];
        $response = $this->actingAs($user)
            ->from('/labels/create')
            ->post('labels', $data);
        $response->assertRedirect('/labels/create');
        $response->assertSessionHasErrors(['name' => 'Это обязательное поле']);

        $data = ['name' => 'Название метки'];
        $response = $this->actingAs($user)->post('labels', $data);
        $response->assertRedirect('/labels');

        $data = ['name' => 'Название метки'];
        $response = $this->actingAs($user)
            ->from('/labels/create')
            ->post('labels', $data);
        $response->assertRedirect('/labels/create');
        $response->assertSessionHasErrors(['name' => 'Метка с таким именем уже существует']);
    }
}
