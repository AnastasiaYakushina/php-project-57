<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Label;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public function testLabelsStatusesIndex(): void
    {
        Label::factory()->create(['name' => 'Срочно']);
        Label::factory()->create(['name' => 'Важно']);

        $response = $this->get(route('labels.index'));

        $response->assertOk();
        $response->assertSee('Срочно');
        $response->assertSee('Важно');
        $response->assertDontSee('Не существует');
    }

    public function testLabelsIndexAsGuest(): void
    {
        $response = $this->get(route('labels.index'));

        $response->assertOk();
        $response->assertDontSee('Создать');
        $response->assertDontSee('Изменить');
        $response->assertDontSee('Удалить');
    }

    public function testLabelsRedirectToAuthPageForGuest(): void
    {
        $label = Label::factory()->create();

        $routes = [
            ['get', route('labels.create'), []],
            ['get', route('labels.edit', $label), []],
            ['post', route('labels.store'), ['name' => 'test']],
            ['put', route('labels.update', $label), ['name' => 'test']],
            ['delete', route('labels.destroy', $label), []],
        ];

        foreach ($routes as [$method, $url, $data]) {
            $response = call_user_func([$this, $method], $url, $data);
            $response->assertForbidden();
        }
    }

    public function testLabelsCreate(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('labels.create'));

        $response->assertOk();
        $response->assertSee('name="name"', false);
        $response->assertSee('name="description"', false);
    }

    public function testLabelsStore(): void
    {
        $user = User::factory()->create();
        $data = ['name' => 'Я создана'];

        $response = $this->actingAs($user)->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', ['name' => 'Я создана']);
    }

    public function testLabelsEdit(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $response = $this->actingAs($user)->get(route('labels.edit', $label));

        $response->assertOk();
        $response->assertSee('name="name"', false);
    }

    public function testLabelsUpdate(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create(['name' => 'Я до изменения']);
        $data = ['name' => 'Я изменена', 'description' => 'Новое описание'];

        $response = $this->actingAs($user)->patch(route('labels.update', $label), $data);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['name' => 'Я изменена', 'description' => 'Новое описание']);
    }

    public function testLabelDestroy(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $response = $this->actingAs($user)->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testLabelsWithTaskNonDestroy(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach($label->id);

        $response = $this->actingAs($user)->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function testLabelsCorrectValidation(): void
    {
        $user = User::factory()->create();
        $data = ['name' => ''];

        $response = $this->actingAs($user)
            ->from(route('labels.create'))
            ->post(route('labels.store'), $data);
        $response->assertRedirect(route('labels.create'));
        $response->assertSessionHasErrors(['name' => 'Это обязательное поле']);

        $data = ['name' => 'Название метки'];

        $response = $this->actingAs($user)->post(route('labels.store'), $data);
        $response->assertRedirect(route('labels.index'));

        $data = ['name' => 'Название метки'];

        $response = $this->actingAs($user)
            ->from(route('labels.create'))
            ->post(route('labels.store'), $data);
        $response->assertRedirect(route('labels.create'));
        $response->assertSessionHasErrors(['name' => 'Метка с таким именем уже существует']);
    }
}
