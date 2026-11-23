<?php

namespace App\Http\Controllers;

use App\Models\RevenueStatus;
use Illuminate\Http\Request;

class RevenueStatusController extends Controller
{
    /**
     * Afficher la liste des statuts.
     */
    public function index()
    {
        $revenueStatuses = RevenueStatus::all();

        return view('revenue-status.index', compact('revenueStatuses'));
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create()
    {
        return view('revenue-status.create');
    }

    /**
     * Enregistrer un nouveau statut.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255|unique:revenue_statuses,name',
            ],
            [
                'name.required' => 'Merci de saisir le nom du statut.',
                'name.unique' => 'Ce statut existe déjà.',
            ]
        );

        RevenueStatus::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('revenue-status.index')
            ->with('success', 'Le statut a été ajouté avec succès.');
    }

    /**
     * Afficher un statut.
     */
    public function show($id)
    {
        $revenueStatus = RevenueStatus::findOrFail($id);

        return view('revenue-status.show', compact('revenueStatus'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit($id)
    {
        $revenueStatus = RevenueStatus::findOrFail($id);

        return view('revenue-status.edit', compact('revenueStatus'));
    }

    /**
     * Mettre à jour un statut.
     */
    public function update(Request $request, $id)
    {
        $revenueStatus = RevenueStatus::findOrFail($id);

        $request->validate(
            [
                'name' => 'required|max:255|unique:revenue_statuses,name,' . $revenueStatus->id,
            ],
            [
                'name.required' => 'Merci de saisir le nom du statut.',
                'name.unique' => 'Ce statut existe déjà.',
            ]
        );

        $revenueStatus->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('revenue-status.index')
            ->with('success', 'Le statut a été modifié avec succès.');
    }

    /**
     * Supprimer un statut.
     */
    public function destroy($id)
    {
        $revenueStatus = RevenueStatus::findOrFail($id);

        $revenueStatus->delete();

        return redirect()
            ->route('revenue-status.index')
            ->with('success', 'Le statut a été supprimé avec succès.');
    }
}