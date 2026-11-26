<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // Liste des utilisateurs
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }


    // Formulaire ajout
    public function create()
    {
        return view('users.create');
    }


    // Enregistrement utilisateur
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);


        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role' => $request->role

        ]);


        return redirect()
            ->route('users.index')
            ->with('success','Utilisateur ajouté avec succès');

    }



    // Affichage détail utilisateur
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }



    // Suppression
    public function destroy(User $user)
    {

        $user->delete();


        return redirect()
            ->route('users.index')
            ->with('success','Utilisateur supprimé');

    }
    public function edit(User $user)
{
    return view('users.edit', compact('user'));
}


// Mise à jour utilisateur
public function update(Request $request, User $user)
{

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'role' => 'required'
    ]);


    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role
    ]);


    // Modifier le mot de passe seulement s'il est rempli
    if($request->password)
    {
        $user->update([
            'password' => Hash::make($request->password)
        ]);
    }


    return redirect()
        ->route('users.index')
        ->with('success','Utilisateur modifié avec succès');

}

}