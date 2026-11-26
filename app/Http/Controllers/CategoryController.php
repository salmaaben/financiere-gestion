<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Afficher la liste des catégories
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }



    /**
     * Afficher le formulaire d'ajout
     */
    public function create()
    {
        return view('categories.create');
    }



    /**
     * Enregistrer une nouvelle catégorie
     */
    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

        ]);


        Category::create([

            'name' => $request->name,

            'description' => $request->description,

        ]);


        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie ajoutée avec succès');

    }




    /**
     * Afficher une catégorie
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }





    /**
     * Afficher le formulaire de modification
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }





    /**
     * Modifier une catégorie
     */
    public function update(Request $request, Category $category)
    {

        $request->validate([

            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

        ]);



        $category->update([

            'name' => $request->name,

            'description' => $request->description,

        ]);



        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie modifiée avec succès');

    }





    /**
     * Supprimer une catégorie
     */
    public function destroy(Category $category)
    {

        $category->delete();


        return redirect()
            ->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès');

    }

}