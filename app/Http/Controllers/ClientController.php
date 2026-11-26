<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:clients,name',
            'description' => 'nullable',
        ]);

        Client::create($request->all());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Le client a été ajouté avec succès.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255|unique:clients,name,' . $client->id,
            'description' => 'nullable',
        ]);

        $client->update($request->all());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Le client a été modifié avec succès.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Le client a été supprimé avec succès.');
    }
}