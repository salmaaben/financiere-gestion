@extends('adminlte::page')

@section('title', 'Modifier une TVA')

@section('content_header')

<h1>
    <i class="fas fa-edit"></i>
    Modifier une TVA
</h1>

@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form action="{{ route('tva.update', $tva->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="libelle">Libellé</label>

                <input type="text"
                       name="libelle"
                       id="libelle"
                       class="form-control"
                       value="{{ $tva->libelle }}"
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
                       value="{{ $tva->taux }}"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Enregistrer les modifications
            </button>

            <a href="{{ route('tva.index') }}" class="btn btn-secondary">
                Retour
            </a>

        </form>

    </div>

</div>

@stop