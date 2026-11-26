<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Revenue;
use App\Models\Label;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RapportController extends Controller
{
    /**
     * Page principale
     */
public function index()
{
    $libellesExistants = Label::query()
        ->whereNotNull('name')
        ->where('name', '!=', '')
        ->orderBy('name')
        ->pluck('name');

    return view('rapports.index', compact('libellesExistants'));
}

    /**
     * Générer le rapport
     */
    public function generer(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',
            'libelle'    => 'nullable|string|max:255',
        ]);

        $data = $this->getReportData($request);

        return view('rapports.index', $data);
    }


    /**
     * Page de modification du rapport
     */
    public function modifier(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',
            'libelle'    => 'nullable|string|max:255',
        ]);

        $data = $this->getReportData($request);

        return view('rapports.modifier', $data);
    }


    /**
     * Générer le PDF à partir du rapport modifié
     */
    public function pdf(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',
            'libelle'    => 'nullable|string|max:255',

            // Informations générales
            'titre' => 'nullable|string|max:255',
            'nom_etablissement' => 'nullable|string|max:255',
            'periode' => 'nullable|string|max:255',
            'commentaire_general' => 'nullable|string|max:5000',
            'footer' => 'nullable|string|max:255',
            'note_finale' => 'nullable|string|max:5000',

            // Résumé
            'resume' => 'nullable|array',
            'resume.revenus' => 'nullable|numeric',
            'resume.depenses' => 'nullable|numeric',
            'resume.tva' => 'nullable|numeric',
            'resume.solde' => 'nullable|numeric',
            'resume_labels' => 'nullable|array',
            'resume_labels.*' => 'nullable|string|max:255',

            // Charges
            'charges' => 'nullable|array',
            'charges.*.categorie' => 'nullable|string|max:255',
            'charges.*.montant' => 'nullable|numeric',
            'charges.*.commentaire' => 'nullable|string|max:1000',

            // Réservations
            'reservations' => 'nullable|array',
            'reservations.*.client' => 'nullable|string|max:255',
            'reservations.*.check_in' => 'nullable|date',
            'reservations.*.check_out' => 'nullable|date',
            'reservations.*.nuitees' => 'nullable|numeric',
            'reservations.*.montant' => 'nullable|numeric',
            'reservations.*.commentaire' => 'nullable|string|max:1000',

            // Occupation
            'occupation' => 'nullable|array',
            'occupation.nuitees' => 'nullable|numeric',
            'occupation.taux' => 'nullable|numeric',
            'occupation_labels' => 'nullable|array',
            'occupation_labels.*' => 'nullable|string|max:255',

            // Interventions
            'interventions' => 'nullable|array',
            'interventions.*.action' => 'nullable|string|max:1000',
            'interventions.*.date' => 'nullable|date',
            'interventions.*.responsable' => 'nullable|string|max:255',
            'interventions.*.commentaire' => 'nullable|string|max:1000',

            // Actions d'amélioration
            'actions' => 'nullable|array',
            'actions.*.action' => 'nullable|string|max:1000',
            'actions.*.priorite' => 'nullable|string|max:255',
            'actions.*.consequence' => 'nullable|string|max:1000',

            // Titres des sections
            'titre_charges' => 'nullable|string|max:255',
            'titre_recettes' => 'nullable|string|max:255',
            'titre_interventions' => 'nullable|string|max:255',
            'titre_actions' => 'nullable|string|max:255',
        ]);

        $data = $this->getReportData($request);

        // Informations générales personnalisées
        $data['titre'] = $request->input('titre', 'Compte rendu financier');
        $data['nom_etablissement'] = $request->input('nom_etablissement', 'MyStay');
        $data['periode'] = $request->input('periode', '');
        $data['commentaire_general'] = $request->input('commentaire_general', '');
        $data['footer'] = $request->input('footer', 'MyStay');
        $data['note_finale'] = $request->input('note_finale', '');

        // Titres des sections
        $data['titre_charges'] = $request->input('titre_charges', 'Charges');
        $data['titre_recettes'] = $request->input('titre_recettes', 'Recettes / Réservations');
        $data['titre_interventions'] = $request->input('titre_interventions', 'Journal des interventions');
        $data['titre_actions'] = $request->input('titre_actions', "Actions d'amélioration");

        // Résumé financier modifié
        $resume = $request->input('resume', []);
        $data['revenuTotal'] = (float) ($resume['revenus'] ?? $data['revenuTotal']);
        $data['depenseTotale'] = (float) ($resume['depenses'] ?? $data['depenseTotale']);
        $data['tva'] = (float) ($resume['tva'] ?? $data['tva']);
        $data['solde'] = (float) ($resume['solde'] ?? $data['solde']);

        // Charges modifiées
        $charges = collect($request->input('charges', []))
            ->map(function ($charge) {
                return (object) [
                    'categorie' => $charge['categorie'] ?? '',
                    'montant_ttc' => (float) ($charge['montant'] ?? 0),
                    'commentaire' => $charge['commentaire'] ?? '',
                    'description' => $charge['commentaire'] ?? '',
                ];
            })
            ->filter(function ($charge) {
                return trim($charge->categorie) !== ''
                    || $charge->montant_ttc != 0
                    || trim($charge->commentaire) !== '';
            })
            ->values();

        $data['depenses'] = $charges;

        $data['amenagements'] = collect();
        $data['amenagementTotal'] = 0;

        // Réservations modifiées
        $reservations = collect($request->input('reservations', []))
            ->map(function ($reservation) {
                return (object) [
                    'client' => $reservation['client'] ?? '',
                    'check_in' => $reservation['check_in'] ?? '',
                    'check_out' => $reservation['check_out'] ?? '',
                    'nombre_nuitees' => (int) ($reservation['nuitees'] ?? 0),
                    'montant_ttc' => (float) ($reservation['montant'] ?? 0),
                    'commentaire' => $reservation['commentaire'] ?? '',
                ];
            })
            ->filter(function ($reservation) {
                return trim($reservation->client) !== ''
                    || $reservation->montant_ttc != 0
                    || $reservation->nombre_nuitees != 0
                    || trim($reservation->commentaire) !== '';
            })
            ->values();

        $data['reservations'] = $reservations;

        // Occupation modifiée
        $occupation = $request->input('occupation', []);
        $data['totalNuitees'] = (float) ($occupation['nuitees'] ?? $data['totalNuitees']);
        $data['tauxOccupation'] = (float) ($occupation['taux'] ?? $data['tauxOccupation']);

        // Interventions modifiées
        $interventions = collect($request->input('interventions', []))
            ->map(function ($intervention) {
                return (object) [
                    'action' => $intervention['action'] ?? '',
                    'date' => $intervention['date'] ?? '',
                    'responsable' => $intervention['responsable'] ?? '',
                    'commentaire' => $intervention['commentaire'] ?? '',
                ];
            })
            ->filter(function ($intervention) {
                return trim($intervention->action) !== ''
                    || trim($intervention->responsable) !== ''
                    || trim($intervention->commentaire) !== '';
            })
            ->values();

        $data['interventions'] = $interventions;

        // Actions d'amélioration modifiées
        $actions = collect($request->input('actions', []))
            ->map(function ($action) {
                return (object) [
                    'action' => $action['action'] ?? '',
                    'priorite' => $action['priorite'] ?? '',
                    'consequence' => $action['consequence'] ?? '',
                ];
            })
            ->filter(function ($action) {
                return trim($action->action) !== ''
                    || trim($action->priorite) !== ''
                    || trim($action->consequence) !== '';
            })
            ->values();

        $data['actions'] = $actions;

        $data['fraisAgence'] = $data['fraisAgence'] ?? 0;
        $data['revenuNet'] = $data['revenuTotal'] - $data['depenseTotale'] - $data['fraisAgence'];

        $pdf = Pdf::loadView('rapports.pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('rapport-financier.pdf');
    }


    /**
     * Récupérer les données du rapport
     */
    private function getReportData(Request $request): array
    {
        $libelle = trim((string) $request->input('libelle', ''));

        $revenusQuery = Revenue::whereBetween('date', [$request->date_debut, $request->date_fin]);
        $depensesQuery = Expense::whereBetween('date', [$request->date_debut, $request->date_fin]);

        if ($libelle !== '') {
            $revenusQuery->where('libelle', 'LIKE', '%' . $libelle . '%');
            $depensesQuery->where('libelle', 'LIKE', '%' . $libelle . '%');
        }

        $revenus = $revenusQuery->orderBy('date')->get();
        $depenses = $depensesQuery->orderBy('date')->get();

        $revenuTotal = $revenus->sum(function ($revenu) {
            return (float) ($revenu->montant_ttc ?? 0);
        });

        $depenseTotale = $depenses->sum(function ($depense) {
            return (float) ($depense->montant_ttc ?? 0);
        });

        $tvaRevenus = $revenus->sum(function ($revenu) {
            return (float) ($revenu->montant_tva ?? 0);
        });

        $tvaDepenses = $depenses->sum(function ($depense) {
            return (float) ($depense->montant_tva ?? 0);
        });

        $tva = $tvaRevenus - $tvaDepenses;

        $solde = $revenuTotal - $depenseTotale;

        $pourcentage = $revenuTotal > 0
            ? round(($depenseTotale / $revenuTotal) * 100, 2)
            : 0;

        $reservations = $revenus;

        $amenagements = collect();
        $amenagementTotal = $amenagements->sum(function ($item) {
            return (float) ($item->montant ?? 0);
        });

        $totalNuitees = $reservations->sum(function ($reservation) {
            return (float) ($reservation->nombre_nuitees ?? 0);
        });

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);

        $nombreJours = $dateDebut->diffInDays($dateFin) + 1;

        if ($nombreJours > 0) {
            $tauxOccupation = round(($totalNuitees / $nombreJours) * 100, 2);
            $tauxOccupation = min($tauxOccupation, 100);
        } else {
            $tauxOccupation = 0;
        }

        $interventions = collect();
        $actions = collect();
        $fraisAgence = 0;

        $revenuNet = $revenuTotal - $depenseTotale - $fraisAgence;

        // Récupérer la liste des libellés pour l'affichage dynamique dans le formulaire de la vue
        $libellesExistants = Revenue::select('libelle')
            ->whereNotNull('libelle')
            ->where('libelle', '!=', '')
            ->union(
                Expense::select('libelle')
                    ->whereNotNull('libelle')
                    ->where('libelle', '!=', '')
            )
            ->distinct()
            ->orderBy('libelle')
            ->pluck('libelle');

        return [
            'revenus' => $revenus,
            'depenses' => $depenses,
            'reservations' => $reservations,
            'revenuTotal' => $revenuTotal,
            'depenseTotale' => $depenseTotale,
            'solde' => $solde,
            'tva' => $tva,
            'pourcentage' => $pourcentage,
            'libelle' => $libelle,
            'libellesExistants' => $libellesExistants, // <-- Ajouté ici
            'amenagements' => $amenagements,
            'amenagementTotal' => $amenagementTotal,
            'interventions' => $interventions,
            'actions' => $actions,
            'tauxOccupation' => $tauxOccupation,
            'totalNuitees' => $totalNuitees,
            'fraisAgence' => $fraisAgence,
            'revenuNet' => $revenuNet,
            'dateDebut' => $request->date_debut,
            'dateFin' => $request->date_fin,
        ];
    }
}