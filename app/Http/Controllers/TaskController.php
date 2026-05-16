<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }


    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            )
            ->with(['status', 'createdBy', 'assignedTo', 'labels'])
            ->paginate(10);

        $taskStatuses = TaskStatus::all();
        $users = User::all();

        return view('tasks.index', compact('tasks', 'taskStatuses', 'users'));
    }


    public function create()
    {
        $task = new Task();
        $taskStatuses = TaskStatus::all();
        $labels = Label::all();
        $users = User::all();

        return view('tasks.create', compact('task', 'taskStatuses', 'labels', 'users'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'status_id' => 'required|exists:task_statuses,id',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ], [
            'name.required' => 'Это обязательное поле',
            'name.max' => 'Название задачи не может превышать 255 символов',
            'status_id.required' => 'Это обязательное поле',
        ]);

        $task = new Task();
        $task = Auth::user()->createdTasks()->create($validated);

        $task->labels()->sync($request->input('labels', []));

        flash('Задача успешно создана')->success();
        return redirect()
            ->route('tasks.index');
    }


    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }


    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();

        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels'));
    }


    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'status_id' => 'required|exists:task_statuses,id',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ], [
            'name.required' => 'Это обязательное поле',
            'name.max' => 'Название задачи не может превышать 255 символов',
            'status_id.required' => 'Это обязательное поле',
        ]);

        $task->fill($validated);
        $task->save();

        $task->labels()->sync($request->input('labels', []));

        flash('Задача успешно изменена')->success();
        return redirect()
            ->route('tasks.index');
    }


    public function destroy(Task $task)
    {
        $task->delete();

        flash('Задача успешно удалена')->success();
        return redirect()->route('tasks.index');
    }
}
