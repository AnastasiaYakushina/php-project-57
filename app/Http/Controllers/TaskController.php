<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            )
            ->with(['status', 'creator', 'executor', 'labels'])
            ->get();

        $taskStatuses = TaskStatus::all();
        $users = User::all();

        return view('tasks.index', compact('tasks', 'taskStatuses', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $taskStatuses = TaskStatus::all();
        $labels = Label::all();
        $users = User::all();

        return view('tasks.create', compact('task', 'taskStatuses', 'labels', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'status_id' => 'required|exists:task_statuses,id',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ], [
            'name.required' => 'Это обязательное поле',
            'status_id.required' => 'Это обязательное поле',
        ]);

        $task = new Task();
        $task->fill($data);
        $task->fill(['created_by_id' => auth()->id()]);
        $task->save();

        $task->labels()->sync($request->input('labels', []));

        flash('Задача успешно создана')->success();
        return redirect()
            ->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();

        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required',
            'status_id' => 'required|exists:task_statuses,id',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ], [
            'name.required' => 'Это обязательное поле',
            'status_id.required' => 'Это обязательное поле',
        ]);

        $task->fill($data);
        $task->save();

        $task->labels()->sync($request->input('labels', []));

        flash('Задача успешно изменена')->success();
        return redirect()
            ->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        flash('Задача успешно удалена')->success();
        return redirect()->route('tasks.index');
    }
}
