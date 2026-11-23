<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Afficher la liste des fournisseurs.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::all();

        return view('fournisseurs.index', compact('fournisseurs'));
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create()
    {
        return view('fournisseurs.create');
    }

    /**
     * Enregistrer un nouveau fournisseur.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255|unique:fournisseurs,name',
                'description' => 'nullable'
            ],
            [
                'name.required' => 'Merci de saisir le nom du fournisseur.',
                'name.unique' => 'Ce fournisseur existe déjà.',
            ]
        );

        Fournisseur::create($request->all());

        return redirect()
            ->route('fournisseurs.index')
            ->with('success', 'Le fournisseur a été ajouté avec succès.');
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        return view('fournisseurs.edit', compact('fournisseur'));
    }

    /**
     * Mettre à jour un fournisseur.
     */
    public function update(Request $request, $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        $request->validate(
            [
                'name' => 'required|max:255|unique:fournisseurs,name,' . $id,
                'description' => 'nullable'
            ],
            [
                'name.required' => 'Merci de saisir le nom du fournisseur.',
                'name.unique' => 'Ce fournisseur existe déjà.',
            ]
        );

        $fournisseur->update($request->all());

        return redirect()
            ->route('fournisseurs.index')
            ->with('success', 'Le fournisseur a été modifié avec succès.');
    }

    /**
     * Supprimer un fournisseur.
     */
    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        $fournisseur->delete();

        return redirect()
            ->route('fournisseurs.index')
            ->with('success', 'Le fournisseur a été supprimé avec succès.');
    }
}