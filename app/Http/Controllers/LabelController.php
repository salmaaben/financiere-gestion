<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::all();

        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        return view('labels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        Label::create($request->all());

        return redirect()->route('labels.index')
            ->with('success', 'Libellé ajouté avec succès.');
    }

    public function edit($id)
    {
        $label = Label::findOrFail($id);

        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, $id)
    {
        $label = Label::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $label->update($request->all());

        return redirect()->route('labels.index')
            ->with('success', 'Libellé modifié avec succès.');
    }

    public function destroy($id)
    {
        Label::findOrFail($id)->delete();

        return redirect()->route('labels.index')
            ->with('success', 'Libellé supprimé avec succès.');
    }
}