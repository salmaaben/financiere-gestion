<?php

namespace App\Http\Controllers;

use App\Models\Tva;
use Illuminate\Http\Request;

class TvaController extends Controller
{
    /**
     * Afficher la liste des TVA.
     */
    public function index()
    {
        $tvas = Tva::all();

        return view('tva.index', compact('tvas'));
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create()
    {
        return view('tva.create');
    }

    /**
     * Enregistrer une nouvelle TVA.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'taux' => 'required|numeric|min:0|max:100',
        ]);

        Tva::create([
            'libelle' => $request->libelle,
            'taux' => $request->taux,
        ]);

        return redirect()
            ->route('tva.index')
            ->with('success', 'La TVA a été ajoutée avec succès.');
    }

    /**
     * Afficher les détails d'une TVA.
     */
    public function show(Tva $tva)
    {
        return view('tva.show', compact('tva'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Tva $tva)
    {
        return view('tva.edit', compact('tva'));
    }

    /**
     * Mettre à jour une TVA.
     */
    public function update(Request $request, Tva $tva)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'taux' => 'required|numeric|min:0|max:100',
        ]);

        $tva->update([
            'libelle' => $request->libelle,
            'taux' => $request->taux,
        ]);

        return redirect()
            ->route('tva.index')
            ->with('success', 'La TVA a été modifiée avec succès.');
    }

    /**
     * Supprimer une TVA.
     */
    public function destroy(Tva $tva)
    {
        $tva->delete();

        return redirect()
            ->route('tva.index')
            ->with('success', 'La TVA a été supprimée avec succès.');
    }
}