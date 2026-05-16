<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskStatusController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class);
    }


    public function index()
    {
        $taskStatuses = TaskStatus::paginate(10);
        return view('task_statuses.index', compact('taskStatuses'));
    }


    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:task_statuses',
        ], [
            'name.required' => 'Это обязательное поле',
            'name.max' => 'Название статуса не может превышать 255 символов',
            'name.unique' => 'Статус с таким именем уже существует',
        ]);

        $taskStatus = new TaskStatus();
        $taskStatus->fill($validated);
        $taskStatus->save();

        flash('Статус успешно создан')->success();
        return redirect()
            ->route('task_statuses.index');
    }


    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }


    public function update(Request $request, TaskStatus $taskStatus)
    {
        $validated = $request->validate([
            'name' => "required|max:255|unique:task_statuses,name,{$taskStatus->id}",
        ], [
            'name.required' => 'Это обязательное поле',
            'name.max' => 'Название статуса не может превышать 255 символов',
            'name.unique' => 'Статус с таким именем уже существует',
        ]);

        $taskStatus->fill($validated);
        $taskStatus->save();

        flash('Статус успешно изменён')->success();
        return redirect()
            ->route('task_statuses.index');
    }


    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash('Не удалось удалить статус')->error();
            return redirect()->route('task_statuses.index');
        }
        $taskStatus->delete();

        flash('Статус успешно удалён')->success();
        return redirect()->route('task_statuses.index');
    }
}
