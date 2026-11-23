<?php

namespace App\Http\Controllers;

use App\Models\TypePiece;
use Illuminate\Http\Request;

class TypePieceController extends Controller
{
    /**
     * Afficher la liste des types de pièces comptables.
     */
    public function index()
    {
        $typePieces = TypePiece::all();

        return view('type-pieces.index', compact('typePieces'));
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create()
    {
        return view('type-pieces.create');
    }

    /**
     * Enregistrer un nouveau type.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255|unique:type_pieces,name',
            ],
            [
                'name.required' => 'Merci de saisir le type de pièce comptable.',
                'name.unique'   => 'Ce type de pièce existe déjà.',
            ]
        );

        TypePiece::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('type-pieces.index')
            ->with('success', 'Le type de pièce a été ajouté avec succès.');
    }

    /**
     * Afficher un type de pièce.
     */
    public function show($id)
    {
        $typePiece = TypePiece::findOrFail($id);

        return view('type-pieces.show', compact('typePiece'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit($id)
    {
        $typePiece = TypePiece::findOrFail($id);

        return view('type-pieces.edit', compact('typePiece'));
    }

    /**
     * Mettre à jour un type de pièce.
     */
    public function update(Request $request, $id)
    {
        $typePiece = TypePiece::findOrFail($id);

        $request->validate(
            [
                'name' => 'required|max:255|unique:type_pieces,name,' . $typePiece->id,
            ],
            [
                'name.required' => 'Merci de saisir le type de pièce comptable.',
                'name.unique'   => 'Ce type de pièce existe déjà.',
            ]
        );

        $typePiece->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('type-pieces.index')
            ->with('success', 'Le type de pièce a été modifié avec succès.');
    }

    /**
     * Supprimer un type de pièce.
     */
    public function destroy($id)
    {
        $typePiece = TypePiece::findOrFail($id);

        $typePiece->delete();

        return redirect()
            ->route('type-pieces.index')
            ->with('success', 'Le type de pièce a été supprimé avec succès.');
    }
}