<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = TaskStatus::all();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:task_statuses',
        ], [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует',
        ]);

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();

        flash('Статус успешно создан')->success();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $request->validate([
            'name' => "required|unique:task_statuses,name,{$taskStatus->id}",
        ], [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Статус с таким именем уже существует',
        ]);

        $taskStatus->fill($data);
        $taskStatus->save();

        flash('Статус успешно изменён')->success();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
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
