<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Label;
use App\Models\Fournisseur;
use App\Models\ExpenseStatus;
use App\Models\Tva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ExpenseController extends Controller
{
    /**
     * Afficher la liste des dépenses
     */
    public function index()
    {
        $expenses = Expense::latest()->get();

        return view('depenses.index', compact('expenses'));
    }

    /**
     * Afficher le formulaire d'ajout
     */

public function create()
{
    $categories = Category::all();
    $labels = Label::all();
    $fournisseurs = Fournisseur::all();
    $expenseStatuses = ExpenseStatus::orderBy('name')->get();
    $tvas = Tva::orderBy('taux')->get();

    $modes = DB::table('modes_paiement')
        ->orderBy('libelle')
        ->get();

    return view('depenses.create', compact(
        'categories',
        'labels',
        'fournisseurs',
        'expenseStatuses',
        'tvas',
        'modes'
    ));
}


    /**
     * Enregistrer une nouvelle dépense
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'numero_piece' => 'required|max:255',
                'type' => 'required|max:255',
                'mode_paiement' => 'required|max:255',
                'montant_ttc' => 'required|numeric',
                'montant_tva' => 'nullable|numeric',
                'devise' => 'required|max:10',
                'statut' => 'required|max:255',
                'fournisseur' => 'required|max:255',
                'categorie' => 'required|max:255',
                'libelle' => 'required|max:255',
                'date' => 'required|date',
                'date_echeance' => 'nullable|date',
                'date_valeur' => 'nullable|date',
                'commentaire' => 'nullable',
                'lien_justificatif' => 'nullable|max:255',
                'lien_justificatif_comptable' => 'nullable|max:255',
                'tva_id' => 'nullable|exists:tvas,id',
            ],
            [
                'numero_piece.required' => 'Merci de remplir le champ "Numéro de pièce comptable".',
                'type.required' => 'Merci de sélectionner le type.',
                'mode_paiement.required' => 'Merci de sélectionner le mode de paiement.',
                'montant_ttc.required' => 'Merci de saisir le montant TTC.',
                'montant_ttc.numeric' => 'Le montant TTC doit être un nombre.',
                'statut.required' => 'Merci de sélectionner le statut.',
                'fournisseur.required' => 'Merci de sélectionner un fournisseur.',
                'categorie.required' => 'Merci de sélectionner une catégorie.',
                'libelle.required' => 'Merci de sélectionner un libellé.',
                'date.required' => 'Merci de sélectionner la date.',
                'devise.required' => 'Merci de sélectionner la devise.',
            ]
        );

        Expense::create($request->all());

        return redirect()
            ->route('expenses.index')
            ->with('success', 'La dépense a été ajoutée avec succès.');
    }

    /**
     * Afficher une dépense
     */
    public function show($id)
    {
        $expense = Expense::findOrFail($id);

        return view('depenses.show', compact('expense'));
    }

    /**
     * Afficher le formulaire de modification
     */
public function edit($id)
{
    $expense = Expense::findOrFail($id);

    $categories = Category::orderBy('name')->get();
    $labels = Label::orderBy('name')->get();
    $fournisseurs = Fournisseur::orderBy('name')->get();
    $expenseStatuses = ExpenseStatus::orderBy('name')->get();
    $tvas = Tva::orderBy('taux')->get();

    // Récupérer les modes de paiement
    $modes = DB::table('modes_paiement')
        ->orderBy('libelle')
        ->get();

    return view('depenses.edit', compact(
        'expense',
        'categories',
        'labels',
        'fournisseurs',
        'expenseStatuses',
        'tvas',
        'modes'
    ));
}

    /**
     * Mettre à jour une dépense
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'numero_piece' => 'required|max:255',
                'type' => 'required|max:255',
                'mode_paiement' => 'required|max:255',
                'montant_ttc' => 'required|numeric',
                'montant_tva' => 'nullable|numeric',
                'devise' => 'required|max:10',
                'statut' => 'required|max:255',
                'fournisseur' => 'required|max:255',
                'categorie' => 'required|max:255',
                'libelle' => 'required|max:255',
                'date' => 'required|date',
                'date_echeance' => 'nullable|date',
                'date_valeur' => 'nullable|date',
                'commentaire' => 'nullable',
                'lien_justificatif' => 'nullable|max:255',
                'lien_justificatif_comptable' => 'nullable|max:255',
            ]
        );

        $expense = Expense::findOrFail($id);

        $expense->update($request->all());

        return redirect()
            ->route('expenses.index')
            ->with('success', 'La dépense a été modifiée avec succès.');
    }

    /**
     * Supprimer une dépense
     */
   public function destroy($id)
{
    // Vérification stricte côté serveur
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Action non autorisée. Seul un administrateur peut supprimer cet élément.');
    }

    // Suite de votre logique de suppression...
    $revenu = Revenue::findOrFail($id); // ou Expense::findOrFail($id)
    $revenu->delete();

    return redirect()->back()->with('success', 'Élément supprimé avec succès.');
}
}