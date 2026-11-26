@extends('adminlte::page')

@section('title', 'Ajouter une TVA')

@section('content_header')

<h1>
    <i class="fas fa-plus"></i>
    Ajouter une TVA
</h1>

@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form action="{{ route('tva.store') }}" method="POST">

            @csrf

            <div class="form-group">
                <label for="libelle">Libellé</label>

                <input type="text"
                       name="libelle"
                       id="libelle"
                       class="form-control"
                       placeholder="Exemple : TVA normale"
                       required>
            </div>

            <div class="form-group">
                <label for="taux">Taux de TVA (%)</label>

                <input type="number"
                       name="taux"
                       id="taux"
                       class="form-control"
                       step="0.01"
                       min="0"
                       max="100"
                       placeholder="Exemple : 20"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Enregistrer
            </button>

            <a href="{{ route('tva.index') }}" class="btn btn-secondary">
                Retour
            </a>

        </form>

    </div>

</div>

@stop