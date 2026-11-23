<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModePaiementController extends Controller

{
    public function index()
    {
        $modes = DB::table('modes_paiement')
            ->orderBy('libelle')
            ->get();

        return view('modes-paiement.index', compact('modes'));
    }

    public function create()
    {
        return view('modes-paiement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255|unique:modes_paiement,libelle',
        ]);

        DB::table('modes_paiement')->insert([
            'libelle' => $request->libelle,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('modes-paiement.index')
            ->with('success', 'Mode de paiement ajouté avec succès.');
    }

    public function edit($id)
    {
        $mode = DB::table('modes_paiement')->where('id', $id)->first();

        abort_if(!$mode, 404);

        return view('modes-paiement.edit', compact('mode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:255|unique:modes_paiement,libelle,' . $id,
        ]);

        DB::table('modes_paiement')->where('id', $id)->update([
            'libelle' => $request->libelle,
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('modes-paiement.index')
            ->with('success', 'Mode de paiement modifié avec succès.');
    }

    public function destroy($id)
    {
        DB::table('modes_paiement')->where('id', $id)->delete();

        return redirect()
            ->route('modes-paiement.index')
            ->with('success', 'Mode de paiement supprimé avec succès.');
    }
}
