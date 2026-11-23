<?php
namespace App\Http\Controllers;

use App\Models\Revenue;
use App\Models\RevenueStatus;
use App\Models\Tva;
use App\Models\TypePiece;
use App\Models\Client;
use App\Models\Category;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RevenueController extends Controller
{
    /**
     * Afficher la liste des revenus
     */
    public function index()
    {
        $revenus = Revenue::orderBy('id', 'desc')->get();

        return view('revenus.index', compact('revenus'));
    }

    /**
     * Afficher le formulaire d'ajout
     */
    public function create()
    {
        $revenueStatuses = RevenueStatus::orderBy('name')->get();
        $tvas = Tva::orderBy('taux')->get();
        $typePieces = TypePiece::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $labels = Label::orderBy('name')->get();

        $modes = DB::table('modes_paiement')
            ->orderBy('libelle')
            ->get();

        return view('revenus.create', compact(
            'revenueStatuses',
            'tvas',
            'typePieces',
            'clients',
            'categories',
            'labels',
            'modes'
        ));
    }

    /**
     * Enregistrer un nouveau revenu
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_piece' => 'required',
            'type_piece' => 'required',
            'montant_ttc' => 'required|numeric|min:0',
            'tva_id' => 'nullable|exists:tvas,id',
            'montant_tva' => 'nullable|numeric|min:0',
            'devise' => 'required',
            'statut' => 'required',
            'client' => 'required',
            'categorie' => 'required',
            'libelle' => 'required',
            'mode_paiement' => 'nullable|string',
            'date' => 'required|date',
            'date_echeance' => 'nullable|date',
            'date_valeur' => 'nullable|date',
            'commentaire' => 'nullable',
            'lien_justificatif' => 'nullable|url',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after_or_equal:check_in',
            'nombre_nuitees' => 'nullable|integer|min:0',
        ], [
            'numero_piece.required' => 'Merci de remplir le numéro de pièce.',
            'type_piece.required' => 'Merci de sélectionner le type de pièce.',
            'montant_ttc.required' => 'Merci de remplir le montant TTC.',
            'montant_ttc.numeric' => 'Le montant TTC doit être un nombre.',
            'tva_id.exists' => 'La TVA sélectionnée est invalide.',
            'montant_tva.numeric' => 'Le montant TVA doit être un nombre.',
            'statut.required' => 'Merci de sélectionner un statut.',
            'client.required' => 'Merci de remplir le champ Client.',
            'categorie.required' => 'Merci de remplir le champ Catégorie.',
            'libelle.required' => 'Merci de remplir le champ Libellé.',
            'date.required' => 'Merci de sélectionner la date.',
            'date.date' => 'La date est invalide.',
            'date_echeance.date' => "La date d'échéance est invalide.",
            'date_valeur.date' => 'La date de valeur est invalide.',
            'check_in.date' => 'La date de check-in est invalide.',
            'check_out.date' => 'La date de check-out est invalide.',
            'check_out.after_or_equal' => 'La date de check-out doit être postérieure ou égale au check-in.',
            'nombre_nuitees.integer' => 'Le nombre de nuitées doit être un entier.',
            'lien_justificatif.url' => 'Le lien du justificatif est invalide.',
        ]);

        Revenue::create($request->all());

        return redirect()
            ->route('revenus.index')
            ->with('success', 'Le revenu a été ajouté avec succès.');
    }

    /**
     * Afficher les détails d'un revenu
     */
    public function show($id)
    {
        $revenue = Revenue::findOrFail($id);

        return view('revenus.show', compact('revenue'));
    }

    /**
     * Afficher le formulaire de modification
     */
  public function edit($id)
{
    $revenu = Revenue::findOrFail($id);

    $revenueStatus = RevenueStatus::orderBy('name')->get();
    $tvas = Tva::orderBy('taux')->get();
    $typePieces = TypePiece::orderBy('name')->get();

    $modes = DB::table('modes_paiement')
        ->orderBy('libelle')
        ->get();

    $clients = Client::orderBy('name')->get();
    $categories = Category::orderBy('name')->get();
    $labels = Label::orderBy('name')->get();

    return view('revenus.edit', compact(
        'revenu',
        'typePieces',
        'revenueStatus',
        'tvas',
        'modes',
        'clients',
        'categories',
        'labels'
    ));
}

    /**
     * Mettre à jour un revenu
     */
    public function update(Request $request, $id)
    {
        $revenu = Revenue::findOrFail($id);

        $request->validate([
            'numero_piece' => 'required',
            'type_piece' => 'required',
            'montant_ttc' => 'required|numeric|min:0',
            'tva_id' => 'nullable|exists:tvas,id',
            'montant_tva' => 'nullable|numeric|min:0',
            'devise' => 'required',
            'statut' => 'required',
            'client' => 'required',
            'categorie' => 'required',
            'libelle' => 'required',
            'mode_paiement' => 'nullable|string',
            'date' => 'required|date',
            'date_echeance' => 'nullable|date',
            'date_valeur' => 'nullable|date',
            'commentaire' => 'nullable',
            'lien_justificatif' => 'nullable|url',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after_or_equal:check_in',
            'nombre_nuitees' => 'nullable|integer|min:0',
        ], [
            'numero_piece.required' => 'Merci de remplir le numéro de pièce.',
            'type_piece.required' => 'Merci de sélectionner le type de pièce.',
            'montant_ttc.required' => 'Merci de remplir le montant TTC.',
            'montant_ttc.numeric' => 'Le montant TTC doit être un nombre.',
            'tva_id.exists' => 'La TVA sélectionnée est invalide.',
            'montant_tva.numeric' => 'Le montant TVA doit être un nombre.',
            'statut.required' => 'Merci de sélectionner un statut.',
            'client.required' => 'Merci de remplir le champ Client.',
            'categorie.required' => 'Merci de remplir le champ Catégorie.',
            'libelle.required' => 'Merci de remplir le champ Libellé.',
            'date.required' => 'Merci de sélectionner la date.',
            'date.date' => 'La date est invalide.',
            'date_echeance.date' => "La date d'échéance est invalide.",
            'date_valeur.date' => 'La date de valeur est invalide.',
            'check_in.date' => 'La date de check-in est invalide.',
            'check_out.date' => 'La date de check-out est invalide.',
            'check_out.after_or_equal' => 'La date de check-out doit être postérieure ou égale au check-in.',
            'nombre_nuitees.integer' => 'Le nombre de nuitées doit être un entier.',
            'lien_justificatif.url' => 'Le lien du justificatif est invalide.',
        ]);

        $revenu->update($request->all());

        return redirect()
            ->route('revenus.index')
            ->with('success', 'Le revenu a été modifié avec succès.');
    }

    /**
     * Supprimer un revenu
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
