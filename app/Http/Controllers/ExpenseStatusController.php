<?php

namespace App\Http\Controllers;

use App\Models\ExpenseStatus;
use Illuminate\Http\Request;

class ExpenseStatusController extends Controller
{
    /**
     * Afficher la liste des statuts.
     */
    public function index()
    {
        $expenseStatuses = ExpenseStatus::all();

        return view('expense-status.index', compact('expenseStatuses'));
    }

    /**
     * Formulaire d'ajout.
     */
    public function create()
    {
        return view('expense-status.create');
    }

    /**
     * Enregistrer un statut.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255|unique:expense_statuses,name',
            ],
            [
                'name.required' => 'Merci de saisir le nom du statut.',
                'name.unique' => 'Ce statut existe déjà.',
            ]
        );

        ExpenseStatus::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('expense-status.index')
            ->with('success', 'Le statut a été ajouté avec succès.');
    }

    /**
     * Afficher un statut.
     */
    public function show($id)
    {
        $expenseStatus = ExpenseStatus::findOrFail($id);

        return view('expense-status.show', compact('expenseStatus'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit($id)
    {
        $expenseStatus = ExpenseStatus::findOrFail($id);

        return view('expense-status.edit', compact('expenseStatus'));
    }

    /**
     * Mettre à jour.
     */
    public function update(Request $request, $id)
    {
        $expenseStatus = ExpenseStatus::findOrFail($id);

        $request->validate(
            [
                'name' => 'required|max:255|unique:expense_statuses,name,' . $expenseStatus->id,
            ],
            [
                'name.required' => 'Merci de saisir le nom du statut.',
                'name.unique' => 'Ce statut existe déjà.',
            ]
        );

        $expenseStatus->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('expense-status.index')
            ->with('success', 'Le statut a été modifié avec succès.');
    }

    /**
     * Supprimer.
     */
    public function destroy($id)
    {
        $expenseStatus = ExpenseStatus::findOrFail($id);

        $expenseStatus->delete();

        return redirect()
            ->route('expense-status.index')
            ->with('success', 'Le statut a été supprimé avec succès.');
    }
}