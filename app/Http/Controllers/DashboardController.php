<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // TOTAL REVENUS ET DEPENSES
        $revenuTotal = Revenue::sum('montant_ttc');
        $depenseTotale = Expense::sum('montant_ttc');

        // SOLDE GENERAL
        $solde = $revenuTotal - $depenseTotale;

        // TVA
        $tvaRevenu = Revenue::sum('montant_tva');
        $tvaDepense = Expense::sum('montant_tva');

        // POURCENTAGE DES DEPENSES
        $pourcentage = 0;

        if ($revenuTotal > 0) {
            $pourcentage = round(
                ($depenseTotale / $revenuTotal) * 100,
                2
            );
        }

        // CAISSE : ESPECES
        $revenusEspeces = Revenue::where(
            'mode_paiement',
            'Espèce'
        )->sum('montant_ttc');

        $depensesEspeces = Expense::where(
            'mode_paiement',
            'Espèces'
        )->sum('montant_ttc');

        $caisse = $revenusEspeces - $depensesEspeces;


        // BANQUE : VIREMENT ET VERSEMENT
        $revenusBanque = Revenue::whereIn('mode_paiement', [
            'Virement',
            'Versement'
        ])->sum('montant_ttc');

        $depensesBanque = Expense::whereIn('mode_paiement', [
            'Virement',
            'Versement'
        ])->sum('montant_ttc');

        $banque = $revenusBanque - $depensesBanque;


        // =====================================
        // DETTES : MONTANTS A PAYER
        // =====================================

        $detteAPayer = Expense::whereIn('statut', [
            'En attente',
            'À payer'
        ])->sum('montant_ttc');


        // DETTES EN RETARD
        $detteEnRetard = Expense::where(
            'statut',
            'En retard'
        )->sum('montant_ttc');


        // TOTAL DES DETTES
        $dette = $detteAPayer + $detteEnRetard;


        // =====================================
        // CREANCES : MONTANTS A ENCAISSER
        // =====================================

        $creanceAEncaisser = Revenue::whereIn('statut', [
            'En attente',
            'À encaisser'
        ])->sum('montant_ttc');


        // CREANCES EN RETARD
        $creanceEnRetard = Revenue::where(
            'statut',
            'En retard'
        )->sum('montant_ttc');


        // TOTAL DES CREANCES
        $creance = $creanceAEncaisser + $creanceEnRetard;


        // TRESORERIE TOTALE
        $totalTreso = $revenuTotal - $depenseTotale;


        // IMPOT SUR LES SOCIETES
        $is = $solde * 0.20;


        // REVENUS PAR MOIS
        $revenusParMois = Revenue::select(
            DB::raw('MONTH(date) mois'),
            DB::raw('SUM(montant_ttc) total')
        )
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();


        // DEPENSES PAR MOIS
        $depensesParMois = Expense::select(
            DB::raw('MONTH(date) mois'),
            DB::raw('SUM(montant_ttc) total')
        )
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();


        // LABELS DES MOIS
        $labels = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0, 0, 0, $i, 1));
        }


        // REVENUS
        $revenus = [];

        for ($i = 1; $i <= 12; $i++) {
            $revenus[] = optional(
                $revenusParMois->where('mois', $i)->first()
            )->total ?? 0;
        }


        // DEPENSES
        $depenses = [];

        for ($i = 1; $i <= 12; $i++) {
            $depenses[] = optional(
                $depensesParMois->where('mois', $i)->first()
            )->total ?? 0;
        }


        // RETOUR VERS LE DASHBOARD
        return view('dashboard', compact(
            'revenuTotal',
            'depenseTotale',
            'solde',
            'tvaRevenu',
            'tvaDepense',
            'pourcentage',
            'caisse',
            'banque',
            'dette',
            'detteAPayer',
            'detteEnRetard',
            'creance',
            'creanceAEncaisser',
            'creanceEnRetard',
            'totalTreso',
            'is',
            'labels',
            'revenus',
            'depenses'
        ));
    }
}
