<?php

namespace App\Http\Controllers;

use App\Exports\FinancialExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExportController extends Controller
{
    public function export(Request $request)
    {
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $libelle = $request->input('libelle');

        return Excel::download(
            new FinancialExport(
                $dateDebut,
                $dateFin,
                $libelle
            ),
            'Rapport_Financier_MyStay.xlsx'
        );
    }
}
