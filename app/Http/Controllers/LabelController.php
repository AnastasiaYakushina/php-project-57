<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LabelController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Label::class);
    }

    public function index()
    {
        $labels = Label::all();
        return view('labels.index', compact('labels'));
    }


    public function create()
    {
        $label = new Label();
        return view('labels.create', compact('label'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:labels',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Метка с таким именем уже существует',
        ]);

        $label = new Label();
        $label->fill($validated);
        $label->save();

        flash('Метка успешно создана')->success();
        return redirect()
            ->route('labels.index');
    }


    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }


    public function update(Request $request, Label $label)
    {
        $validated = $request->validate([
            'name' => "required|unique:labels,name,{$label->id}",
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Метка с таким именем уже существует',
        ]);

        $label->fill($validated);
        $label->save();

        flash('Метка успешно изменена')->success();
        return redirect()
            ->route('labels.index');
    }


    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash('Не удалось удалить метку')->error();
            return redirect()->route('labels.index');
        }
        $label->delete();

        flash('Метка успешно удалена')->success();
        return redirect()->route('labels.index');
    }
}
